<?php

namespace App\Http\Livewire\Admin\Trash;

use App\Http\Controllers\UserActivityController;
use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Livewire\Component;

class TrashPage extends Component
{
    private function getMainMenus()
    {
        $mainMenus = array();

        $trashed = MainMenu::onlyTrashed()->get();
        foreach ($trashed as $trash) {
            array_push($mainMenus, [
                'id' => $trash->id,
                'mainMenu' => $trash->mainMenu,
                'deleted_at' => date('M-d-Y h:i A', strtotime($trash->deleted_at)),
            ]);
        }
        return $mainMenus;
    }

    private function getSubMenus()
    {
        $subMenus = array();
        $trashed = SubMenu::onlyTrashed()->get();
        foreach ($trashed as $trash) {
            $mainMenu = $this->getMainMenuByID($trash->main_menu_id);
            array_push($subMenus, [
                'id' => $trash->id,
                'mainMenu' => $mainMenu->mainMenu,
                'subMenu' => $trash->subMenu,
                'deleted_at' => date('M-d-Y h:i A', strtotime($trash->deleted_at)),
            ]);
        }
        return $subMenus;
    }

    private function getContents()
    {
        $contents = array();
        $trashed = Content::onlyTrashed()->get();
        foreach ($trashed as $trash) {
            $mainMenu = $this->getMainMenuByID($trash->main_menu_id);
            $subMenu = $this->getSubMenuByID($trash->sub_menu_id);
            array_push($contents, [
                'id' => $trash->id,
                'mainMenu' => $mainMenu->mainMenu,
                'subMenu' => $subMenu->subMenu,
                'title' => $trash->title,
                'deleted_at' => date('M-d-Y h:i A', strtotime($trash->deleted_at)),
            ]);
        }
        return $contents;
    }

    public function render()
    {
        return view('livewire.admin.trash.trash-page', [
            'mainMenus' => $this->getMainMenus(),
            'subMenus' => $this->getSubMenus(),
            'contents' => $this->getContents(),
        ])->extends('layouts.app')
            ->section('content');
    }

    private function getMainMenuByID($id)
    {
        return MainMenu::withTrashed()->where('id', $id)->first();
    }

    public function restoreSelectedMainMenu($id)
    {
        $mainMenu = $this->getMainMenuByID($id);
        $mainMenu->restore();

        $log = [];
        $log['action'] = "Restored Main Menu";
        $log['content'] = "Main Menu: " . $mainMenu->mainMenu;
        $log['changes'] = "";
        UserActivityController::store($log);
        $this->dispatchBrowserEvent('restore-selected');
    }

    private function getSubMenuByID($id)
    {
        return SubMenu::withTrashed()->where('id', $id)->first();
    }

    public function restoreSelectedSubMenu($id)
    {
        $subMenu = $this->getSubMenuByID($id);
        $subMenu->restore();

        $mainMenu = $subMenu->mainMenu()->first();

        $log = [];
        $log['action'] = "Restored Sub Menu";
        $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ', Sub Menu: ' . $subMenu->subMenu;
        $log['changes'] = "";
        UserActivityController::store($log);
        $this->dispatchBrowserEvent('restore-selected');
    }

    public function restoreSelectedContent($id)
    {
        $content = Content::withTrashed()->where('id', $id)->first();
        $content->restore();
        $content->mainMenu()->restore();
        $content->subMenu()->restore();

        $mainMenu = $content->mainMenu()->first();
        $subMenu = $content->subMenu()->first();

        $log = [];
        $log['action'] = "Restored Content";
        $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ', Sub Menu: ' . $subMenu->subMenu . ', Content Title: ' . $content->title;
        $log['changes'] = "";
        UserActivityController::store($log);
        $this->dispatchBrowserEvent('restore-selected');
    }
}
