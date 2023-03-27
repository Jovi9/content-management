<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu\Content;
use App\Models\Menu\SubMenu;
use Illuminate\Http\Request;
use App\Models\Menu\MainMenu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\UserLogActivityController;
use App\Http\Requests\Admin\Menu\ContentCreateRequest;
use App\Http\Requests\Admin\Menu\ContentUpdateRequest;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.menu.contents.contents');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($menu)
    {
        if (ucwords($menu) == "Home" || ucwords($menu) == "About" || ucwords($menu) == "Contact Us") {
            return Redirect::back();
        }

        return view('admin.menu.contents.create', [
            'menu' => $menu
        ]);
    }

    public function createSubContent($menu, $sub_menu)
    {
        if (ucwords($menu) == "Home" || ucwords($menu) == "About" || ucwords($menu) == "Contact Us") {
            return Redirect::back();
        }

        return view('admin.menu.contents.create', [
            'is_SubMenu' => true,
            'menu' => $menu,
            'subMenu' => $sub_menu
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentCreateRequest $request)
    {
        $mainMenu = MainMenu::where('main_menu', $request->main_menu)->first();
        $subMenuID = '';
        $actionLog = '';

        // check if has submenu
        if (isset($request->sub_menu)) {
            $subMenu = SubMenu::where('sub_menu', $request->sub_menu)->first();
            $subMenuID = $subMenu->id;
            $actionLog = ucwords($request->main_menu) . '->' . ucwords($request->sub_menu);
        } else {
            $subMenuID = 1;
            $actionLog = ucwords($request->main_menu);
        }

        $status = '';
        if (Auth::user()->user_type_id == 1) {
            $status = 'approved';
        } else {
            $status = 'pending';
        }

        $contents = [
            'main_menu_id' => $mainMenu->id,
            'sub_menu_id' => $subMenuID,
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status
        ];

        $query = Content::create($contents);

        $log = [];
        $log['action'] = "Uploaded Content to " . $actionLog;
        $log['content'] = "Title: " . $contents['title'];
        $log['changes'] = "";

        if ($query) {
            UserLogActivityController::store($log);

            if (isset($request->sub_menu)) {
                return Redirect::route('user.show-content-sub', ['menu' => $mainMenu->main_menu, 'sub_menu' => $subMenu->sub_menu])->with('saved', 'success');
            } else {
                return Redirect::route('user.show-content-main', ['menu' => $mainMenu->main_menu])->with('saved', 'success');
            }
        } else {
            return Redirect::back()->withErrors(['error' => 'Failed to process request.']);
        }
    }

    public function imageUpload(Request $request)
    {
        $location = '';
        if ($request->menu) {
            $menu = MainMenu::where('main_menu', $request->menu)->first();
            $location = $menu->location;
        } elseif ($request->subMenu) {
            $subMenu = SubMenu::where('sub_menu', $request->subMenu)->first();
            $location = $subMenu->sub_location;
        }
        $origFile = $request->file('file');
        $newFile = $origFile->hashName();

        $fileName = explode('.', $newFile);
        $fileExt = $origFile->extension();

        $finalFileName = $fileName[0] . time() . '.' . $fileExt;

        $path = $request->file('file')->storeAs($location, $finalFileName, 'public');
        return response()->json(['location' => "/storage/$path"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        if (ucwords($menu) == "Home" || ucwords($menu) == "About" || ucwords($menu) == "Contact Us") {
            return Redirect::back();
        }
        $menu = MainMenu::where('main_menu', $menu)->first();

        $contents = Content::where('main_menu_id', $menu->id)->get();

        return view('admin.menu.contents.show', [
            'menu' => $menu,
            'subMenu' => 'none',
            'contents' => $contents
        ]);
    }

    public function showSubContent($menu, $sub_menu)
    {
        // main menu & sub menu
        if (ucwords($menu) == "Home" || ucwords($menu) == "About" || ucwords($menu) == "Contact Us") {
            return Redirect::back();
        }

        $menu = MainMenu::where('main_menu', $menu)->first();
        $subMenu = SubMenu::where('sub_menu', $sub_menu)->first();

        $contents = Content::where('main_menu_id', $menu->id)
            ->where('sub_menu_id', $subMenu->id)
            ->get();

        return view('admin.menu.contents.show', [
            'is_SubMenu' => $subMenu->sub_menu,
            'menu' => $menu,
            'subMenu' => $subMenu->id,
            'contents' => $contents
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($menu, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return back();
        }
        if (ucwords($menu) == "Home" || ucwords($menu) == "About" || ucwords($menu) == "Contact Us") {
            return Redirect::back();
        }

        $content = Content::where('id', $id)->first();

        return view('admin.menu.contents.edit', [
            'menu' => $menu,
            'subMenu' => 'none',
            'content' => $content
        ]);
    }

    public function editSubContent($menu, $sub_menu, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return back();
        }
        if (ucwords($menu) == "Home" || ucwords($menu) == "About" || ucwords($menu) == "Contact Us") {
            return Redirect::back();
        }

        $content = Content::where('id', $id)->first();

        return view('admin.menu.contents.edit', [
            'menu' => $menu,
            'subMenu' => $sub_menu,
            'content' => $content
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContentUpdateRequest $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return back();
        }

        $actionLog = '';

        // check if has submenu
        if (isset($request->sub_menu)) {
            $actionLog = ucwords($request->main_menu) . '->' . ucwords($request->sub_menu);
        } else {
            $actionLog = ucwords($request->main_menu);
        }

        $status = '';
        if (Auth::user()->user_type_id == 1) {
            $status = 'approved';
        } else {
            $status = 'pending';
        }

        $contents = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status
        ];

        $query = Content::where('id', $id)
            ->update($contents);

        $log = [];
        $log['action'] = "Updated Content of " . $actionLog;
        $log['content'] = "Title: " . $contents['title'];
        $log['changes'] = "Title: " . $contents['title'];

        if ($query) {
            UserLogActivityController::store($log);

            if (isset($request->sub_menu)) {
                return Redirect::route('user.show-content-sub', ['menu' => $request->main_menu, 'sub_menu' => $request->sub_menu])->with('updated', 'success');
            } else {
                return Redirect::route('user.show-content-main', ['menu' => $request->main_menu])->with('updated', 'success');
            }
        } else {
            return Redirect::back()->withErrors(['error' => 'Failed to process request.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
