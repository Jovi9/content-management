<?php

namespace App\Http\Livewire\Content;

use App\Http\Controllers\UserLogActivityController;
use App\Models\User;
use Livewire\Component;
use App\Models\Menu\Content;
use App\Models\Menu\SubMenu;
use App\Models\Menu\MainMenu;
use Illuminate\Support\Facades\Crypt;

class ManageContent extends Component
{
    protected $contents = array();

    protected function getContents()
    {
        $contents = Content::orderBy('status', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($contents as $content) {
            $modified = User::where('id', $content->mod_user_id)->first();
            $mainMenu = MainMenu::where('id', $content->main_menu_id)->first();
            $subMenu = SubMenu::where('id', $content->sub_menu_id)->first();
            $this->contents[] = [
                'id' => $content->id,
                'mainMenu' => $mainMenu->main_menu,
                'subMenu' => $subMenu->sub_menu,
                'title' => $content->title,
                'content' => $content->content,
                'date' => date('M-d-Y h:i A', strtotime($content->created_at)),
                'dateModified' => date('M-d-Y h:i A', strtotime($content->updated_at)),
                'user' => $modified->firstName . ' ' . $modified->lastName,
                'status' => $content->status,
                'isVisible' => $content->isVisible
            ];
        }
    }

    public function render()
    {
        $this->getContents();
        return view('livewire.content.manage-content', [
            'contents' => $this->contents,
        ]);
    }

    public function approveContent($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return;
        }

        $content = Content::where('id', $id)->first();
        $mainMenu = MainMenu::where('id', $content->main_menu_id)->first();
        $subMenu = SubMenu::where('id', $content->sub_menu_id)->first();

        if (strtolower($subMenu->sub_menu) == 'none') {
            $location = $mainMenu;
        } else {
            $location = $mainMenu . ' > ' . $subMenu;
        }

        $query = Content::where('id', $id)
            ->update([
                'status' => 'approved',
                'isVisible' => true
            ]);

        $log = [];
        $log['action'] = "Approved Content";
        $log['content'] = "Menu: " . $location . ", Title: " . $content->title;
        $log['changes'] = "";

        if ($query) {
            UserLogActivityController::store($log);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
            ]);
        }
    }

    public function toggleVisibility($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return;
        }

        $content = Content::where('id', $id)->first();

        if ($content->isVisible == 0) {
            $visibility = true;
        } else {
            $visibility = false;
        }

        $mainMenu = MainMenu::where('id', $content->main_menu_id)->first();
        $subMenu = SubMenu::where('id', $content->sub_menu_id)->first();

        if (strtolower($subMenu->sub_menu) == 'none') {
            $location = $mainMenu->main_menu;
        } else {
            $location = $mainMenu->main_menu . ' > ' . $subMenu->sub_menu;
        }

        $query = Content::where('id', $id)
            ->update([
                'isVisible' => $visibility
            ]);

        $log = [];
        $log['action'] = "Changed Content Visibility";
        $log['content'] = "Menu: " . $location . ", Title: " . $content->title;
        $log['changes'] = "";

        if ($query) {
            UserLogActivityController::store($log);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
            ]);
        }
    }
}
