<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Models\Menu\SubMenu;
use Illuminate\Http\Request;
use App\Models\Menu\MainMenu;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Menu\Content\ContentCreateRequest;
use App\Models\Menu\Content;
use App\Models\User;

class ContentController extends Controller
{
    private function getMainMenus()
    {
        return MainMenu::whereNot('id', 1)
            ->whereNot('isEnabled', false)
            ->get();
    }

    private function getSubMenuCount($mainMenuID)
    {
        return SubMenu::where('main_menu_id', $mainMenuID)
            ->whereNot('id', 1)
            ->whereNot('isEnabled', false)
            ->count();
    }

    private function getSubMenus_ByMainID($mainMenuID)
    {
        // return SubMenu::join('main_menus', 'sub_menus.main_menu_id', '=', 'main_menus.id')
        //     ->select('main_menus.mainMenu', 'main_menus.mainURI', 'sub_menus.subMenu', 'sub_menus.subURI')
        //     ->whereNot('main_menus.id', 1)
        //     ->whereNot(function ($query) {
        //         $query->where('main_menus.isEnabled', false)
        //             ->orWhere('sub_menus.isEnabled', false);
        //     })
        //     ->get();
        return SubMenu::where('main_menu_id', $mainMenuID)
            ->whereNot('id', 1)
            ->whereNot('isEnabled', false)
            ->get();
    }

    private function getMenus()
    {
        $links = array();

        $mainMenus = $this->getMainMenus();
        foreach ($mainMenus as $mainMenu) {
            if ($this->getSubMenuCount($mainMenu->id) > 0) {
                $subMenus = $this->getSubMenus_ByMainID($mainMenu->id);
                foreach ($subMenus as $subMenu) {
                    array_push($links, [
                        'mainMenu' => $mainMenu->mainMenu,
                        'mainURI' => $mainMenu->mainURI,
                        'subMenu' => $subMenu->subMenu,
                        'subURI' => $subMenu->subURI,
                    ]);
                }
            } else {
                array_push($links, [
                    'mainMenu' => $mainMenu->mainMenu,
                    'mainURI' => $mainMenu->mainURI,
                    'subMenu' => 'none',
                ]);
            }
        }
        return $links;
    }

    public function index()
    {
        return view('admin.menus.contents.contents', [
            'menus' => $this->getMenus(),
        ]);
    }

    private function getMainMenu_ByURI($uri)
    {
        return MainMenu::where('mainURI', $uri)
            ->whereNot('id', 1)
            ->whereNot('isEnabled', false)
            ->first();
    }

    private function getSubMenu_ByURI($uri)
    {
        return SubMenu::where('subURI', $uri)
            ->whereNot('id', 1)
            ->whereNot('isEnabled', false)
            ->first();
    }

    private function validateURIRequest(array $request)
    {
        $menu = array();
        $mainMenu = $this->getMainMenu_ByURI($request['mainMenu']);
        if (!($mainMenu)) {
            return false;
        } else {
            if ($this->getSubMenuCount($mainMenu->id) > 0) {
                $subMenu = $this->getSubMenu_ByURI($request['subMenu']);
                if (!($subMenu)) {
                    return false;
                }
                array_push($menu, [
                    'mainMenu' => $mainMenu,
                    'subMenu' => $subMenu,
                ]);
            } else {
                if ($request['subMenu'] == null) {
                    array_push($menu, [
                        'mainMenu' => $mainMenu,
                        'subMenu' => 'none',
                    ]);
                }
            }
        }
        return $menu;
    }

    public function create(Request $request)
    {
        //
        $menu =  $this->validateURIRequest([
            'mainMenu' => $request->main,
            'subMenu' => $request->sub,
        ]);
        if ($menu == false) {
            return Redirect::route('admin.contents-index');
        } else {
            // dd($menu);
            if ($menu[0]['subMenu'] == 'none') {
                $menuName = $menu[0]['mainMenu']->mainMenu;
                $mainMenuID = Crypt::encrypt($menu[0]['mainMenu']->id);;
                $subMenuID = Crypt::encrypt(1);
                $subMenu = 'none';
            } else {
                $menuName = $menu[0]['mainMenu']->mainMenu . ' > ' . $menu[0]['subMenu']->subMenu;
                $mainMenuID = Crypt::encrypt($menu[0]['mainMenu']->id);
                $subMenuID = Crypt::encrypt($menu[0]['subMenu']->id);
                $subMenu = '';
            }

            return view('admin.menus.contents.create', [
                'menuName' => $menuName,
                'mainMenuID' => $mainMenuID,
                'subMenuID' => $subMenuID,
                'subMenu' => $subMenu,
            ]);
        }
    }

    public function uploadImage(Request $request)
    {
        // dd($request);
        try {
            if ($request->mainMenu) {
                $mainMenuID = Crypt::decrypt($request->mainMenu);
                $mainMenu = $this->getMainMenu_ByID($mainMenuID);
                $location = 'contents/' . $mainMenu->mainLocation;
            } elseif ($request->subMenu) {
                $subMenuID = Crypt::decrypt($request->subMenu);
                $subMenu = $this->getSubMenu_ByID($subMenuID);
                $location = 'contents/' . $subMenu->subLocation;
            }
            $origFile = $request->file('file');
            $newFile = $origFile->hashName();

            $fileName = explode('.', $newFile);
            $fileExt = $origFile->extension();

            $finalFileName = $fileName[0] . time() . '.' . $fileExt;

            $path = $request->file('file')->storeAs($location, $finalFileName, 'public');
            return response()->json(['location' => "/storage/$path"]);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'failed']);
        }
    }

    public function store(ContentCreateRequest $request)
    {
        try {
            $mainMenuID = Crypt::decrypt($request->main_menu);
            $subMenuID =  Crypt::decrypt($request->sub_menu);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'failed']);
        }

        $mainMenu = MainMenu::findOrFail($mainMenuID);
        $subMenu = SubMenu::findOrFail($subMenuID);
        $user = User::findOrFail(Auth::user()->id);

        if ($user->hasRole('administrator')) {
            $status = 'approved';
            $visible = true;
        } else {
            $status = 'pending';
            $visible = false;
        }

        if ($subMenuID === 1) {
            $actionLog = ucwords($mainMenu->mainMenu);
        } else {
            $actionLog = ucwords($mainMenu->mainMenu) . ' > ' . ucwords($subMenu->subMenu);
        }

        $contents = [
            'main_menu_id' => $mainMenuID,
            'sub_menu_id' => $subMenuID,
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'user_id' => Auth::id(),
            'mod_user_id' => Auth::id(),
            'isVisible' => $visible,
        ];

        $log = [];
        $log['action'] = "Uploaded Content to " . $actionLog;
        $log['content'] = "Title: " . $contents['title'] . ", Contents: " . $contents['content'];
        $log['changes'] = "";

        $que = Content::create($contents);

        if ($que) {
            UserActivityController::store($log);

            return Redirect::route('admin.contents-index')->with('saved', 'success');
        } else {
            return back()->withErrors(['error' => 'failed']);
        }
    }

    private function getContentCreator_ByID($userID)
    {
        return User::where('id', $userID)->first();
    }

    private function getContents($mainMenuID, $subMenuID)
    {
        //
        $contents = array();

        $allContents = Content::where('main_menu_id', $mainMenuID)
            ->where('sub_menu_id', $subMenuID)
            ->orderBy('arrangement')
            ->get();

        foreach ($allContents as $content) {
            array_push($contents, [
                'id' => Crypt::encrypt($content->id),
                'title' => $content->title,
                'created_at' => date('M-d-Y h:i A', strtotime($content->created_at)),
                'updated_at' => date('M-d-Y h:i A', strtotime($content->updated_at)),
                'status' => $content->status,
                'created_by' => $this->getContentCreator_ByID($content->user_id),
                'updated_by' => $this->getContentCreator_ByID($content->mod_user_id),
            ]);
        }
        return $contents;
    }

    public function show(Request $request)
    {
        //
        $menu =  $this->validateURIRequest([
            'mainMenu' => $request->main,
            'subMenu' => $request->sub,
        ]);
        if ($menu == false) {
            return Redirect::route('admin.contents-index');
        } else {
            $mainMenu = $this->getMainMenu_ByID($menu[0]['mainMenu']->id);
            $mainURI = $mainMenu->mainURI;

            if ($menu[0]['subMenu'] == 'none') {
                $menuName = $menu[0]['mainMenu']->mainMenu;
                $mainMenuID = Crypt::encrypt($menu[0]['mainMenu']->id);;
                $subMenuID = Crypt::encrypt(1);
                $contents = $this->getContents($menu[0]['mainMenu']->id, 1);
                $subURI = 'none';
            } else {
                $menuName = $menu[0]['mainMenu']->mainMenu . ' > ' . $menu[0]['subMenu']->subMenu;
                $mainMenuID = Crypt::encrypt($menu[0]['mainMenu']->id);
                $subMenuID = Crypt::encrypt($menu[0]['subMenu']->id);
                $contents = $this->getContents($menu[0]['mainMenu']->id, $menu[0]['subMenu']->id);
                $subMenu = $this->getSubMenu_ByID($menu[0]['subMenu']->id);
                $subURI = $subMenu->subURI;
            }

            return view('admin.menus.contents.show', [
                'menuName' => $menuName,
                'mainURI' => $mainURI,
                'subURI' => $subURI,
                'mainMenuID' => $mainMenuID,
                'subMenuID' => $subMenuID,
                'contents' => $contents,
            ]);
        }
    }

    private function getMainMenu_ByID($mainMenuID)
    {
        return MainMenu::where('id', $mainMenuID)->first();
    }

    private function getSubMenu_ByID($subMenuID)
    {
        return SubMenu::where('id', $subMenuID)->first();
    }

    private function getContent_ByID($id)
    {
        return Content::where('id', $id)->first();
    }

    public function edit(Request $request)
    {
        try {
            $contentID = Crypt::decrypt($request->id);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'failed']);
        }

        $content = $this->getContent_ByID($contentID);
        $mainMenu = $this->getMainMenu_ByID($content->main_menu_id);
        $subMenu = $this->getSubMenu_ByID($content->sub_menu_id);

        $mainURI = $mainMenu->mainURI;
        $mainMenuID = Crypt::encrypt($mainMenu->id);;

        if ($subMenu->id === 1) {
            $subURI = 'none';
            $subMenuID = Crypt::encrypt(1);;
        } else {
            $subMenuID = Crypt::encrypt($subMenu->id);;
            $subURI = $subMenu->subURI;
        }

        if (isset($request->requestFrom)) {
            $requestFrom = $request->requestFrom;
        } else {
            $requestFrom = '';
        }

        return view('admin.menus.contents.edit', [
            'contentID' => $request->id,
            'menuName' => ucwords($mainMenu->mainMenu . ' > ' . $subMenu->subMenu),
            'mainURI' => $mainURI,
            'subURI' => $subURI,
            'mainMenuID' => $mainMenuID,
            'subMenuID' => $subMenuID,
            'content' => $content,
            'requestFrom' => $requestFrom,
        ]);
    }

    public function update(ContentCreateRequest $request)
    {
        try {
            $contentID = Crypt::decrypt($request->id);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'failed']);
        }

        $content = $this->getContent_ByID($contentID);
        $mainMenu = $this->getMainMenu_ByID($content->main_menu_id);
        $subMenu = $this->getSubMenu_ByID($content->sub_menu_id);

        $user = User::findOrFail(Auth::user()->id);

        if ($user->hasRole('administrator')) {
            $status = 'approved';
            $visible = true;
        } else {
            $status = 'pending';
            $visible = false;
        }

        if ($subMenu->id === 1) {
            $actionLog = ucwords($mainMenu->mainMenu);
        } else {
            $actionLog = ucwords($mainMenu->mainMenu) . ' > ' . ucwords($subMenu->subMenu);
        }

        $contents = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'mod_user_id' => Auth::id(),
            'isVisible' => $visible
        ];

        $log = [];
        $log['action'] = "Updated Content of " . $actionLog;
        $log['content'] = "Title: " . $content->title . ', Content: ' . $content->content;
        $log['changes'] = "Title: " . $contents['title'] . ', Content: ' . $contents['content'];

        $que = Content::where('id', $contentID)
            ->update($contents);

        if ($que) {
            UserActivityController::store($log);

            if (strtolower($request->requestFrom) === 'manage-contents') {
                return Redirect::route('admin.contents-manage')->with('updated', 'success');
            } else {
                if ($subMenu->id === 1) {
                    return Redirect::route('admin.contents-show', ['main' => $mainMenu->mainURI])->with('updated', 'success');
                } else {
                    return Redirect::route('admin.contents-show', ['main' => $mainMenu->mainURI . '/' . $subMenu->subURI])->with('updated', 'success');
                }
            }
        } else {
            return back()->withErrors(['error' => 'failed']);
        }
    }

    public function manageContents()
    {
        return view('admin.menus.contents.manage-contents');
    }
}
