<?php

namespace App\Http\Livewire\Admin\Menus\Contents;

use App\Http\Controllers\UserActivityController;
use App\Models\User;
use Livewire\Component;
use App\Models\Menu\Content;
use App\Models\Menu\SubMenu;
use App\Models\Menu\MainMenu;
use Illuminate\Support\Facades\Crypt;

class ShowContents extends Component
{
    public $mainMenuID, $subMenuID;
    public $contentID;

    public function mount($mainMenuID, $subMenuID)
    {
        $this->mainMenuID = Crypt::decrypt($mainMenuID);
        $this->subMenuID = Crypt::decrypt($subMenuID);
    }

    protected $listeners = ['deleteContent'];

    private function getMainMenuByID($mainMenuID)
    {
        return MainMenu::where('id', $mainMenuID)->first();
    }

    private function getSubMenuByID($subMenuID)
    {
        return SubMenu::where('id', $subMenuID)->first();
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
            // ->orderBy('arrangement')
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
                'isVisibleHome' => $content->isVisibleHome,
                'arrangement' => $content->arrangement,
            ]);
        }
        return $contents;
    }

    public function render()
    {
        $mainMenu = $this->getMainMenuByID($this->mainMenuID);
        $mainURI = $mainMenu->mainURI;

        if ($this->subMenuID === 1) {
            $subURI = 'none';
            $contents = $this->getContents($mainMenu->id, 1);
        } else {
            $subMenu = $this->getSubMenuByID($this->subMenuID);
            $subURI = $subMenu->subURI;
            $contents = $this->getContents($mainMenu->id, $subMenu->id);
        }
        return view('livewire.admin.menus.contents.show-contents', [
            'mainURI' => $mainURI,
            'subURI' => $subURI,
            'contents' => $contents,
        ]);
    }

    private function getContentByID($id)
    {
        return Content::where('id', $id)->first();
    }

    // public function showToHome($id)
    // {
    //     try {
    //         $contentID = Crypt::decrypt($id);
    //     } catch (\Throwable $th) {
    //         $this->dispatchBrowserEvent('swal-modal', [
    //             'title' => 'error'
    //         ]);
    //         return;
    //     };

    //     $content = $this->getContentByID($contentID);
    //     $mainMenu = $this->getMainMenuByID($content->main_menu_id);
    //     $subMenu = $this->getSubMenuByID($content->sub_menu_id);

    //     if ($subMenu->id === 1) {
    //         $menu = $mainMenu->mainMenu;
    //     } else {
    //         $menu = $mainMenu->mainMenu . ' > ' . $subMenu->subMenu;
    //     }

    //     $log = [];
    //     $log['action'] = "Modified Content Visibility to Homepage";

    //     if ($content->isVisibleHome === 0) {
    //         $visibility = true;
    //         $log['content'] = "Menu: " . $menu . ", Title: " . $content->title . ', Visibility: Hidden from homepage.';
    //         $log['changes'] = 'Visibility: Visible to homepage.';
    //     } else {
    //         $visibility = false;
    //         $log['content'] = "Menu: " . $menu . ", Title: " . $content->title . ', Visibility: Visible in homepage.';
    //         $log['changes'] = 'Visibility: Removed from homepage.';
    //     }

    //     $que = Content::where('id', $contentID)
    //         ->update([
    //             'isVisibleHome' => $visibility,
    //         ]);

    //     if ($que) {
    //         UserActivityController::store($log);
    //     } else {
    //         $this->dispatchBrowserEvent('swal-modal', [
    //             'title' => 'error',
    //         ]);
    //     }
    // }

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

        $content = $this->getContentByID($contentID);
        $mainMenu = $content->mainMenu()->first();
        $subMenu = $content->subMenu()->first();
        $content->delete();

        $log = [];
        $log['action'] = "Deleted Content";
        $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ", Sub Menu: " . $subMenu->subMenu . ", Content Title: " . $content->title;
        $log['changes'] = "";
        UserActivityController::store($log);
    }
}
