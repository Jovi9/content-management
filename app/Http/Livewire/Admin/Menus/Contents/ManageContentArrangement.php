<?php

namespace App\Http\Livewire\Admin\Menus\Contents;

use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Livewire\Component;

class ManageContentArrangement extends Component
{

    public $mainURI = '';
    public $subURI = '';
    public $counts = array();
    public $updatingArrangement;

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
        if ($this->updatingArrangement == false) {
            $this->loadCounts(count($contents));
        }
        $this->updatingArrangement = false;
        return view('livewire.admin.menus.contents.manage-content-arrangement', [
            'contents' => $contents,
            'counts' => $this->counts,
        ]);
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('reload-page');
    }

    private function resetCounts()
    {
        unset($this->counts);
        $this->counts = array();
    }

    public function loadCounts($count)
    {
        $this->resetCounts();
        for ($i = 1; $i <= $count; $i++) {
            array_push($this->counts, [
                'count' => $i,
            ]);
        }
    }

    public function resetFormCounts()
    {
        $this->updatingArrangement = false;
        $mainMenu = $this->getMainMenu_ByURI($this->mainURI);
        $subMenu = $this->getSubMenu_ByURI($this->subURI);

        if ($subMenu->id == 1) {
            Content::where('main_menu_id', $mainMenu->id)
                ->update([
                    'arrangement' => 1,
                ]);
        } else {
            Content::where('main_menu_id', $mainMenu->id)
                ->where('sub_menu_id', $subMenu->id)
                ->update([
                    'arrangement' => 1,
                ]);
        }
    }

    public function updateArrangement($num, $contentID)
    {
        $this->updatingArrangement = true;
        $this->resetCounts();

        Content::where('id', $contentID)
            ->update([
                'arrangement' => $num,
            ]);

        $contents = $this->getContents();
        $contentArrangement = array();
        foreach ($contents as $content) {
            $contentArrangement[] = $content['arrangement'];
        }
        for ($i = 1; $i <= count($contents); $i++) {
            if (!($i == $num) && !in_array($i, $contentArrangement)) {
                array_push($this->counts, [
                    'count' => $i,
                ]);
            }
        }

        // for ($i = 1; $i <= count($contents); $i++) {
        //     if (!($i == $num)) {
        //         array_push($this->counts, [
        //             'count' => $i,
        //         ]);
        //     }
        // }
    }
}
