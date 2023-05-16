<?php

namespace App\Http\Livewire\Admin\Trash;

use App\Http\Controllers\UserActivityController;
use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class TrashPage extends Component
{
    public $selected, $arg;

    protected $listeners = ['permanentDeleteSelected'];

    private function getMainMenus()
    {
        $mainMenus = array();

        $trashed = MainMenu::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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
        $trashed = SubMenu::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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
        $trashed = Content::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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
        $this->dispatchBrowserEvent('restore-selected', [
            'title' => 'Selected main menu has been restored.',
        ]);
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
        $this->dispatchBrowserEvent('restore-selected', [
            'title' => 'Selected sub menu has been restored.',
        ]);
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
        $this->dispatchBrowserEvent('restore-selected', [
            'title' => 'Selected content has been restored.',
        ]);
    }

    // delete permanent
    public function deleteSelectedMainMenu($id)
    {
        $this->selected = $id;
        $this->arg = Crypt::encrypt('main-menu');
        $this->dispatchBrowserEvent('permanent-delete', [
            'title' => 'Are You Sure?',
            'text' => 'Warning! This action is permanent and won\'t be undone. All sub menus and contents related to this menu will be permanently deleted.',
        ]);
    }

    public function deleteSelectedSubMenu($id)
    {
        $this->selected = $id;
        $this->arg = Crypt::encrypt('sub-menu');
        $this->dispatchBrowserEvent('permanent-delete', [
            'title' => 'Are You Sure?',
            'text' => 'Warning! This action is permanent and won\'t be undone. All contents related to this menu will be permanently deleted.',
        ]);
    }

    public function deleteSelectedContent($id)
    {
        $this->selected = $id;
        $this->arg = Crypt::encrypt('content');
        $this->dispatchBrowserEvent('permanent-delete', [
            'title' => 'Are You Sure?',
            'text' => 'Warning! This action is permanent and won\'t be undone. This content will be permanently deleted.',
        ]);
    }

    public function permanentDeleteSelected()
    {
        try {
            $argument = Crypt::decrypt($this->arg);
        } catch (\Throwable $th) {
            return;
        }
        if (strtolower($argument) === 'main-menu') {
            $mainMenu = MainMenu::withTrashed()->findOrFail($this->selected);

            $allSubMenus = $mainMenu->subMenus()->withTrashed()->get();
            $subMenus = array();
            foreach ($allSubMenus as $subMenu) {
                array_push($subMenus, [
                    'Name: ' => $subMenu->subMenu,
                ]);
            }

            $allContents = $mainMenu->contents()->withTrashed()->get();
            $contents = array();
            foreach ($allContents as $content) {
                array_push($contents, [
                    'Title: ' => $content->title,
                ]);
            }

            $log = [];
            $log['action'] = "Permanently Deleted Main Menu";
            $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ', Sub Menu: ' . json_encode($subMenus) . ', Contents: ' . json_encode($contents);
            $log['changes'] = "";

            $mainMenu->contents()->forceDelete();
            $mainMenu->subMenus()->forceDelete();
            $mainMenu->forceDelete();

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('deleted-permanently', [
                'title' => 'Selected main menu has been permanently deleted.',
            ]);
        } else if (strtolower($argument) === 'sub-menu') {
            $subMenu = SubMenu::withTrashed()->findOrFail($this->selected);
            $mainMenu = $subMenu->mainMenu()->withTrashed()->first();

            $allContents = $subMenu->contents()->withTrashed()->get();
            $contents = array();
            foreach ($allContents as $content) {
                array_push($contents, [
                    'Title: ' => $content->title,
                ]);
            }

            $log = [];
            $log['action'] = "Permanently Deleted Sub Menu";
            $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ', Sub Menu: ' . $subMenu->subMenu . ', Contents: ' . json_encode($contents);
            $log['changes'] = "";

            $subMenu->contents()->forceDelete();
            $subMenu->forceDelete();

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('deleted-permanently', [
                'title' => 'Selected sub menu has been permanently deleted.',
            ]);
        } else if (strtolower($argument) === 'content') {
            $content = Content::withTrashed()->findOrFail($this->selected);
            $mainMenu = $content->mainMenu()->withTrashed()->first();
            $subMenu = $content->subMenu()->withTrashed()->first();

            $log = [];
            $log['action'] = "Permanently Deleted Content";
            $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ', Sub Menu: ' . $subMenu->subMenu . ', Content Title: ' . $content->title;
            $log['changes'] = "";

            $content->forceDelete();

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('deleted-permanently', [
                'title' => 'Selected content has been permanently deleted.',
            ]);
        } else {
            abort(400, 'Request Failed, Plase try again.');
        }
    }
}
