<?php

namespace App\Http\Controllers;

use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PublicPageController extends Controller
{
    private function getMainMenus()
    {
        return MainMenu::whereNot('isEnabled', false)
            ->whereNot('id', 1)
            ->whereNot('mainMenu', 'about')
            ->get();
    }

    private function getSubMenuCount($mainMenuID)
    {
        return SubMenu::where('main_menu_id', $mainMenuID)
            ->whereNot('id', 1)
            ->whereNot('isEnabled', false)
            ->count();
    }

    private function getSubMenu_ByMainID($mainMenuID)
    {
        return SubMenu::where('main_menu_id', $mainMenuID)
            ->whereNot('isEnabled', false)
            ->get();
    }

    private function getMenus()
    {
        $links = array();

        $mainMenus = $this->getMainMenus();

        foreach ($mainMenus as $mainMenu) {
            if ($this->getSubMenuCount($mainMenu->id) > 0) {
                $subMenu = $this->getSubMenu_ByMainID($mainMenu->id);
                array_push($links, [
                    'mainMenu' => $mainMenu->mainMenu,
                    'mainURI' => $mainMenu->mainURI,
                    'subMenu' => $subMenu,
                ]);
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

    public function index()
    {
        return view('public.home', [
            'mainMenus' => $this->getMenus(),
            'menuName' => 'Home',
        ]);
    }

    public function showAbout()
    {
        $contents = $this->getContents(2, 1);
        return view('public.about', [
            'mainMenus' => $this->getMenus(),
            'menuName' => 'About',
            'contents' => $contents,
        ]);
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

    private function getContents($mainMenuID, $subMenuID)
    {
        return Content::where('main_menu_id', $mainMenuID)
            ->where('sub_menu_id', $subMenuID)
            ->whereNot(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('isVisible', 0);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    // main menu
    public function show(Request $request)
    {
        $menu = $this->validateURIRequest([
            'mainMenu' => $request->main,
            'subMenu' => $request->sub,
        ]);

        if ($menu == false) {
            return Redirect::route('public-home');
        } else {
            $mainMenu = $this->getMainMenu_ByURI($request->main);
            if ($mainMenu) {
                if ($request->sub == '') {
                    //
                    $contents = $this->getContents($mainMenu->id, 1);
                    return view('public.custom-page', [
                        'mainMenus' => $this->getMenus(),
                        'menuName' => $mainMenu->mainMenu,
                        'contents' => $contents,
                    ]);
                } else {
                    //
                    $subMenu = $this->getSubMenu_ByURI($request->sub);
                    if ($subMenu) {
                        $contents = $this->getContents($mainMenu->id, $subMenu->id);
                        return view('public.custom-page', [
                            'mainMenus' => $this->getMenus(),
                            'menuName' => $subMenu->subMenu,
                            'contents' => $contents,
                        ]);
                    } else {
                        return Redirect::route('public-home');
                    }
                }
            } else {
                return Redirect::route('public-home');
            }
        }
    }
}
