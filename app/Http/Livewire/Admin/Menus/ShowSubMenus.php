<?php

namespace App\Http\Livewire\Admin\Menus;

use App\Http\Controllers\UserActivityController;
use Livewire\Component;
use App\Models\Menu\SubMenu;
use App\Models\Menu\MainMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ShowSubMenus extends Component
{
    public $mainURI = '';
    public $subMenuID, $subMenu;

    public function mount($main_menu)
    {
        $this->mainURI = strtolower($main_menu);
        try {
            if (empty($this->getMainMenuByURI())) {
                return Redirect::route('admin.navigations-index');
            }
            if (empty($this->getSubMenus())) {
                return Redirect::route('admin.navigations-index');
            }
        } catch (\Throwable $th) {
            abort(404, 'Not Found');
        }
    }

    protected function rules()
    {
        return [
            'subMenu' => ['required', 'string', 'max:255', Rule::unique(SubMenu::class)],
        ];
    }

    private function getMainMenuByURI()
    {
        return MainMenu::where('mainURI', $this->mainURI)->first();
    }

    private function getSubMenus()
    {
        $subMenus = array();

        $mainMenu = $this->getMainMenuByURI();

        $allSubMenus = $mainMenu->subMenus()->get();

        foreach ($allSubMenus as $subMenu) {
            array_push($subMenus, [
                'id' => $subMenu->id,
                'subMenu' => $subMenu->subMenu,
                'mainURI' => $mainMenu->mainURI,
                'subURI' => $subMenu->subURI,
                'isEnabled' => $subMenu->isEnabled,
            ]);
        }

        return $subMenus;
    }

    public function render()
    {
        return view('livewire.admin.menus.show-sub-menus', [
            'mainMenu' => $this->getMainMenuByURI(),
            'subMenus' => $this->getSubMenus(),
        ])->extends('layouts.app')
            ->section('content');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function formmReset()
    {
        $this->resetExcept('mainURI');
        $this->resetValidation();
    }

    public function closeModal($modal_id)
    {
        $this->formmReset();
        $this->dispatchBrowserEvent('close-modal', ['modal_id' => $modal_id]);
    }

    private function getSubMenuByID($id)
    {
        return SubMenu::where('id', $id)->first();
    }

    public function storeSubMenu()
    {
        try {
            $mainMenu = $this->getMainMenuByURI();

            DB::transaction(function () use ($mainMenu) {
                $mainMenu->subMenus()->create([
                    'subMenu' => ucwords($this->subMenu),
                    'subURI' => strtolower(str_replace(' ', '-', $this->subMenu)),
                ]);

                $subMenu = SubMenu::where('subMenu', $this->subMenu)->first();
                SubMenu::where('id', $subMenu->id)
                    ->update([
                        'subLocation' => $mainMenu->mainLocation . '/' . $subMenu->id,
                    ]);
            });
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $log = [];
        $log['action'] = "Added New Sub Menu";
        $log['content'] = "Sub Menu: " . ucwords($this->subMenu) . ', Main Menu: ' . $mainMenu->mainMenu;
        $log['changes'] = '';

        UserActivityController::store($log);
        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'Added new Sub Menu for ' . $mainMenu->mainMenu,
        ]);
        $this->closeModal('#modalAddSubMenu');
    }

    public function editSubMenu($id)
    {
        $this->subMenuID = $id;
        $subMenu = $this->getSubMenuByID($id);
        $this->subMenu = $subMenu->subMenu;
    }

    public function updateSubMenu()
    {
        $this->validate([
            'subMenu' => ['required', 'string', 'max:255', Rule::unique(SubMenu::class)->ignore($this->subMenuID)],
        ]);

        $subMenuData = [
            'subMenu' => ucwords($this->subMenu),
            'subURI' => strtolower(str_replace(' ', '-', $this->subMenu)),
        ];

        $mainMenu = $this->getMainMenuByURI();
        $subMenu = $this->getSubMenuByID($this->subMenuID);

        $query = SubMenu::where('id', $this->subMenuID)
            ->update($subMenuData);

        if ($query) {
            $log = [];
            $log['action'] = "Updated Sub Menu";
            $log['content'] = "Sub Menu: " . ucwords($subMenu->subMenu) . ', Main Menu: ' . $mainMenu->mainMenu;
            $log['changes'] =  "Sub Menu: " . ucwords($this->subMenu);

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Updated Sub Menu of ' . $mainMenu->mainMenu,
            ]);
            $this->closeModal('#modalEditSubMenu');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function toggleSubMenuStatus($id)
    {
        $subMenu = $this->getSubMenuByID($id);

        $log = [];
        $log['action'] = "Changed Sub Menu Status";

        if ($subMenu->isEnabled) {
            SubMenu::where('id', $id)
                ->update([
                    'isEnabled' => false,
                ]);

            $log['content'] = "Sub Menu: " . ucwords($subMenu->subMenu) . ", Sub Menu Status: Enabled";
            $log['changes'] = "Sub Menu Status: Disabled";

            UserActivityController::store($log);
        } else {
            SubMenu::where('id', $id)
                ->update([
                    'isEnabled' => true,
                ]);

            $log['content'] = "Sub Menu: " . ucwords($subMenu->subMenu) . ", Sub Menu Status: Disabled";
            $log['changes'] = "Sub Menu Status: Enabled";
            UserActivityController::store($log);
        }
    }
}
