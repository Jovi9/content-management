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
    public $contentID;

    protected $listeners = ['deleteContent'];

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

    public function deleteSelected($id)
    {
        $this->contentID = $id;
        $this->dispatchBrowserEvent('delete-selected', [
            'title' => 'Are you sure?',
            'text' => 'Warning! The selected content will be moved to trash.',
        ]);
    }

    public function deleteContent()
    {
        try {
            $contentID = Crypt::decrypt($this->contentID);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $content = $this->getContent($contentID);
        $mainMenu = $content->mainMenu()->first();
        $subMenu = $content->subMenu()->first();
        $content->delete();

        $log = [];
        $log['action'] = "Deleted Content";
        $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ", Sub Menu: " . $subMenu->subMenu . ", Content Title: " . $content->title;
        $log['changes'] = "";
        UserActivityController::store($log);
    }

    private function getContentByID($id)
    {
        return Content::where('id', $id)->first();
    }

    public function modalShowDetails($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $data = $this->getContentByID($id);
        $content = array();
        $mainMenu = $data->mainMenu()->first();
        $subMenu = $data->subMenu()->first();
        $createdBy = $data->createdBy()->first();
        $updatedBy = $data->updatedBy()->first();
        $content['mainMenu'] = $mainMenu->mainMenu;
        $content['subMenu'] = $subMenu->subMenu;
        $content['title'] = $data->title;
        $content['createdBy'] = $createdBy->firstName . ' ' . $createdBy->middleName . ' ' . $createdBy->lastName . ' ' . $createdBy->prefix;
        $content['updatedBy'] = $updatedBy->firstName . ' ' . $updatedBy->middleName . ' ' . $updatedBy->lastName . ' ' . $updatedBy->prefix;
        $content['created_at'] = date('M-d-Y h:i A', strtotime($data->created_at));
        $content['updated_at'] = date('M-d-Y h:i A', strtotime($data->updated_at));
        $content['status'] = ucwords($data->status);
        if ($data->isVisible === 0) {
            $visible = "False";
        } else {
            $visible = "True";
        }
        $content['visible'] = $visible;
        $this->dispatchBrowserEvent('populate-modal', [
            'content' => $content,
        ]);
    }
}
