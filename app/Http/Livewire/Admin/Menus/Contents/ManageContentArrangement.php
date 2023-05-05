<?php

namespace App\Http\Livewire\Admin\Menus\Contents;

use App\Http\Controllers\UserActivityController;
use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Livewire\Component;

class ManageContentArrangement extends Component
{

    public $mainURI = '';
    public $subURI = '';

    protected $listeners = ['updateArrangement'];

    public function mount($mainURI, $subURI)
    {
        $this->mainURI = $mainURI;
        $this->subURI = $subURI;
    }

    private function getMainMenu_ByURI($mainURI)
    {
        return MainMenu::where('mainURI', $mainURI)->first();
    }

    private function getSubMenu_ByURI($subURI)
    {
        return SubMenu::where('subURI', $subURI)->first();
    }

    private function getContents()
    {
        $contents = array();

        $mainMenu = $this->getMainMenu_ByURI($this->mainURI);
        $subMenu = $this->getSubMenu_ByURI($this->subURI);
        $allContents = Content::where('main_menu_id', $mainMenu->id)
            ->where('sub_menu_id', $subMenu->id)
            ->orderBy('arrangement')
            ->get();

        foreach ($allContents as $content) {
            array_push($contents, [
                'id' => $content->id,
                'title' => $content->title,
                'arrangement' => $content->arrangement,
            ]);
        }

        return $contents;
    }

    public function render()
    {
        $contents = $this->getContents();
        return view('livewire.admin.menus.contents.manage-content-arrangement', [
            'contents' => $contents,
        ]);
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('reload-page');
    }

    // update new arrangement and log action
    public function updateArrangement(array $id)
    {
        if (empty($id)) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'empty',
                'message' => 'Arrangement is empty, please try again.',
            ]);
            return;
        }

        $mainMenu = $this->getMainMenu_ByURI($this->mainURI);
        $subMenu = $this->getSubMenu_ByURI($this->subURI);

        $log = [];

        if ($subMenu->id === 1) {
            $previousArrangement = Content::select('title as Title')
                ->where('main_menu_id', $mainMenu->id)
                ->orderBy('arrangement')
                ->get();
            $log['action'] = "Modified content arrangement of " . $mainMenu->mainMenu;
        } else {
            $previousArrangement = Content::select('title as Title')
                ->where('main_menu_id', $mainMenu->id)
                ->where('sub_menu_id', $subMenu->id)
                ->orderBy('arrangement')
                ->get();
            $log['action'] = "Modified content arrangement of " . $mainMenu->mainMenu . ' > ' . $subMenu->subMenu;
        }
        $log['content'] = 'Content: ' . json_encode($previousArrangement);

        foreach ($id as $key => $cid) {
            Content::where('id', $cid['value'])
                ->update([
                    'arrangement' => $key,
                ]);
        }

        if ($subMenu->id === 1) {
            $newArrangement = Content::select('title as Title')
                ->where('main_menu_id', $mainMenu->id)
                ->orderBy('arrangement')
                ->get();
        } else {
            $newArrangement = Content::select('title as Title')
                ->where('main_menu_id', $mainMenu->id)
                ->where('sub_menu_id', $subMenu->id)
                ->orderBy('arrangement')
                ->get();
        }
        $log['changes'] = 'Changes: ' . json_encode($newArrangement);

        UserActivityController::store($log);

        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'Content arrangement updated successfully.',
        ]);

        $this->closeModal();
    }
}
