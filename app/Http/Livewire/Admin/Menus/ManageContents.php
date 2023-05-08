<?php

namespace App\Http\Livewire\Admin\Menus;

use App\Http\Controllers\UserActivityController;
use App\Models\User;
use Livewire\Component;
use App\Models\Menu\Content;
use App\Models\Menu\SubMenu;
use App\Models\Menu\MainMenu;
use Illuminate\Support\Facades\Crypt;

class ManageContents extends Component
{
    protected function getContents()
    {
        $contents = array();
        $contentsAll = Content::orderBy('status', 'desc')
            ->orderBy('main_menu_id', 'asc')
            ->orderBy('sub_menu_id', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($contentsAll as $content) {
            $createdBy = User::where('id', $content->user_id)->first();
            $updatedBy = User::where('id', $content->mod_user_id)->first();
            $mainMenu = MainMenu::where('id', $content->main_menu_id)->first();
            $subMenu = SubMenu::where('id', $content->sub_menu_id)->first();
            array_push($contents, [
                'id' => Crypt::encrypt($content->id),
                'mainMenu' => $mainMenu->mainMenu,
                'subMenu' => $subMenu->subMenu,
                'mainURI' => $mainMenu->mainURI,
                'subURI' => $subMenu->subURI,
                'title' => $content->title,
                'content' => $content->content,
                'created_at' => date('M-d-Y h:i A', strtotime($content->created_at)),
                'updated_at' => date('M-d-Y h:i A', strtotime($content->updated_at)),
                'createdBy' => $createdBy->firstName . ' ' . $createdBy->lastName,
                'updatedBy' => $updatedBy->firstName . ' ' . $updatedBy->lastName,
                'status' => $content->status,
                'isVisible' => $content->isVisible
            ]);
        }
        return $contents;
    }

    public function render()
    {
        return view('livewire.admin.menus.manage-contents', [
            'contents' => $this->getContents(),
        ]);
    }

    private function getContent($id)
    {
        return Content::where('id', $id)->first();
    }

    private function getMainMenu($mainMenuID)
    {
        return MainMenu::where('id', $mainMenuID)->first();
    }

    private   function getSubMenu($subMenuID)
    {
        return SubMenu::where('id', $subMenuID)->first();
    }

    public function approveContent($id)
    {
        try {
            $contentID = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $content = $this->getContent($contentID);
        $mainMenu = $this->getMainMenu($content->main_menu_id);
        $subMenu = $this->getSubMenu($content->sub_menu_id);

        if ($subMenu->id === 1) {
            $menu = $mainMenu->mainMenu;
        } else {
            $menu = $mainMenu->mainMenu . ' > ' . $subMenu->subMenu;
        }

        $log = [];
        $log['action'] = "Approved Content";
        $log['content'] = "Menu: " . $menu . ", Title: " . $content->title;
        $log['changes'] = "";

        $que = Content::where('id', $contentID)
            ->update([
                'status' => 'approved',
                'isVisible' => true
            ]);

        if ($que) {
            UserActivityController::store($log);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
            ]);
        }
    }

    public function toggleVisibility($id)
    {
        try {
            $contentID = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $content = $this->getContent($contentID);
        $mainMenu = $this->getMainMenu($content->main_menu_id);
        $subMenu = $this->getSubMenu($content->sub_menu_id);

        if ($subMenu->id === 1) {
            $menu = $mainMenu->mainMenu;
        } else {
            $menu = $mainMenu->mainMenu . ' > ' . $subMenu->subMenu;
        }

        $log = [];
        $log['action'] = "Changed Content Visiblity";

        if ($content->isVisible === 0) {
            $visibility = true;
            $log['content'] = "Menu: " . $menu . ", Title: " . $content->title . ', Visibility: Hidden';
            $log['changes'] = 'Visibility: Visible';
        } else {
            $visibility = false;
            $log['content'] = "Menu: " . $menu . ", Title: " . $content->title . ', Visibility: Visible';
            $log['changes'] = 'Visibility: Hidden';
        }

        $que = Content::where('id', $contentID)
            ->update([
                'isVisible' => $visibility,
            ]);

        if ($que) {
            UserActivityController::store($log);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
            ]);
        }
    }
}
