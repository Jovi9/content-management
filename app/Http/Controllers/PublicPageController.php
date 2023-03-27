<?php

namespace App\Http\Controllers;

use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PublicPageController extends Controller
{
    private function fetchMainMenus()
    {
        $links = array();

        $menus = MainMenu::whereNot('status', 'disabled')->get();

        foreach ($menus as $menu) {
            if (
                SubMenu::where('main_menu_id', $menu->id)
                ->whereNot('sub_menu', 'none')
                ->whereNot('sub_status', 'disabled')
                ->count() > 0
            ) {
                $subMenu = SubMenu::where('main_menu_id', $menu->id)
                    ->whereNot('sub_status', 'disabled')
                    ->get();
                array_push($links, [
                    'main_menu' => $menu->main_menu,
                    'sub_menu' => $subMenu
                ]);
            } else {
                array_push($links, [
                    'main_menu' => $menu->main_menu,
                    'sub_menu' => 'none'
                ]);
            }
        }

        return $links;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::where('main_menu_id', 1)->get();

        return view('welcome', [
            'mainMenus' => $this->fetchMainMenus(),
            'menuName' => 'Home',
            'contents' => $contents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($menuName)
    {
        // get menu dateils
        $menu = MainMenu::where('main_menu', $menuName)->first();

        if ($menu == true) {
            // get menu count in sub menu table
            if (
                SubMenu::where('main_menu_id', $menu->id)
                ->whereNot('sub_menu', 'none')
                ->whereNot('sub_status', 'disabled')
                ->count() > 0
            ) {
                return back();
            } else {
                // if no submenu return view/data

                $contents = Content::where('main_menu_id', $menu->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                return view('welcome', [
                    'mainMenus' => $this->fetchMainMenus(),
                    'menuName' => $menuName,
                    'contents' => $contents
                ]);
            }
        } else {
            return back();
        }
    }

    public function show_s($menu, $sub_menu)
    {
        $mainMenu = MainMenu::where('main_menu', $menu)->first();
        $subMenu = SubMenu::where('sub_menu', $sub_menu)->first();

        if ($mainMenu->status == "disabled" || $subMenu->sub_status == "disabled") {
            return Redirect::back();
        }

        $contents = Content::where('main_menu_id', $mainMenu->id)
            ->where('sub_menu_id', $subMenu->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', [
            'mainMenus' => $this->fetchMainMenus(),
            'menuName' => $sub_menu,
            'contents' => $contents
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
