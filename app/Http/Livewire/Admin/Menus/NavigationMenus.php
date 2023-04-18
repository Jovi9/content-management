<?php

namespace App\Http\Livewire\Admin\Menus;

use Livewire\Component;
use App\Models\Menu\SubMenu;
use App\Models\Menu\MainMenu;
use App\Http\Livewire\LiveForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\DB;

class NavigationMenus extends LiveForm
{
    // main menu
    protected $mainMenus;
    public $menu_id, $mainMenu;

    // submenus
    protected $subMenus;
    public $mainMenuID = '';
    public $subMenuID, $subMenu;

    protected function rules()
    {
        return [
            'mainMenu' => ['required', 'string', 'max:255', Rule::unique(MainMenu::class)],
        ];
    }

    protected function getMainMenus()
    {
        $mainMenus = MainMenu::whereNot('id', 1)->get();
        foreach ($mainMenus as $mainMenu) {
            $subMenuCount = SubMenu::where('main_menu_id', $mainMenu->id)->count();
            if ($subMenuCount == 0) {
                $hasSubMenu = false;
            } else {
                $hasSubMenu = true;
            }

            $this->mainMenus[] = [
                'id' => Crypt::encrypt($mainMenu->id),
                'mainMenu' => $mainMenu->mainMenu,
                'URI' => $mainMenu->mainURI,
                'hasSubMenu' => $hasSubMenu,
                'isEnabled' => $mainMenu->isEnabled,
            ];
        }
    }

    public function render()
    {
        $this->getMainMenus();
        try {
            $mainMenuName = $this->getMainMenu_ByID(Crypt::decrypt($this->mainMenuID));
            $mainMenuName = $mainMenuName->mainMenu;
        } catch (\Throwable $th) {
            // throw $th;
            $mainMenuName = "";
        }
        return view('livewire.admin.menus.navigation-menus', [
            'mainMenus' => $this->mainMenus,
            'subMenus' => $this->subMenus,
            'mainMenuName' => $mainMenuName,
        ]);
    }

    protected function getMainMenu_ByID($id)
    {
        return MainMenu::where('id', $id)->first();
    }

    public function store()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $menuInfo = [
                    'mainMenu' => ucwords($this->mainMenu),
                    'mainURI' => strtolower(str_replace(' ', '-', $this->mainMenu)),
                ];

                MainMenu::create($menuInfo);

                $mainMenu = MainMenu::where('mainMenu', $this->mainMenu)->first();

                MainMenu::where('id', $mainMenu->id)
                    ->update([
                        'mainLocation' => $mainMenu->id,
                    ]);
            });
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $log = [];
        $log['action'] = "Added New Menu";
        $log['content'] = "Menu Name: " . ucwords($this->mainMenu);
        $log['changes'] = '';

        UserActivityController::store($log);

        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'New Menu Successfully Added.',
        ]);
        $this->closeModal('#modalAddMainMenu');
    }

    public function edit($id)
    {
        $this->menu_id = $id;
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $mainMenu = $this->getMainMenu_ByID($id);
        $this->mainMenu = $mainMenu->mainMenu;
    }

    public function update()
    {
        try {
            $menuID = Crypt::decrypt($this->menu_id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $this->validate([
            'mainMenu' => ['required', 'string', 'max:255', Rule::unique(MainMenu::class)->ignore($menuID)],
        ]);

        $menuInfo = [
            'mainMenu' => ucwords($this->mainMenu),
            'mainURI' => strtolower(str_replace(' ', '-', $this->mainMenu)),
        ];

        $mainMenu = $this->getMainMenu_ByID($menuID);

        $log = [];
        $log['action'] = "Updated Menu";
        $log['content'] = "Menu Name: " . ucwords($mainMenu->mainMenu);
        $log['changes'] = "Menu Name: " . ucwords($this->mainMenu);

        $query = MainMenu::where('id', $menuID)
            ->update($menuInfo);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Main Menu Updated Successfully.',
            ]);
            $this->closeModal('#modalEditMainMenu');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $menuID = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $mainMenu = $this->getMainMenu_ByID($menuID);

        if ($mainMenu->isEnabled) {
            MainMenu::where('id', $menuID)
                ->update([
                    'isEnabled' => false,
                ]);

            $log = [];
            $log['action'] = "Changed Main Menu Status";
            $log['content'] = "Menu Name: " . ucwords($mainMenu->mainMenu) . ", Menu Status: Enabled";
            $log['changes'] = "Menu Status: Disabled";

            UserActivityController::store($log);
        } else {
            MainMenu::where('id', $menuID)
                ->update([
                    'isEnabled' => true,
                ]);

            $log = [];
            $log['action'] = "Changed Main Menu Status";
            $log['content'] = "Menu Name: " . ucwords($mainMenu->mainMenu) . ", Menu Status: Disabled";
            $log['changes'] = "Menu Status: Enabled";

            UserActivityController::store($log);
        }
    }


    // sub menu
    public function viewSubMenus($id)
    {
        $this->mainMenuID = $id;
        $this->getSubMenus();
    }

    public function addSubMenu($id)
    {
        try {
            $mainMenuID = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $this->mainMenuID = $id;
    }

    protected function getSubMenus()
    {
        try {
            $mainMenuID = Crypt::decrypt($this->mainMenuID);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $mainMenu = $this->getMainMenu_ByID($mainMenuID);

        $subMenus = SubMenu::whereNot('id', 1)
            ->where('main_menu_id', $mainMenuID)
            ->get();
        foreach ($subMenus as $subMenu) {
            $this->subMenus[] = [
                'id' => Crypt::encrypt($subMenu->id),
                'subMenu' => $subMenu->subMenu,
                'mainURI' => $mainMenu->mainURI,
                'subURI' => $subMenu->subURI,
                'isEnabled' => $subMenu->isEnabled,
            ];
        }
    }

    public function formmReset()
    {
        $this->resetExcept(['mainMenuID']);
        $this->resetValidation();
    }

    protected function getSubMenu_ByID($id)
    {
        return SubMenu::where('id', $id)->first();
    }

    public function storeSubMenu()
    {
        $this->validate([
            'subMenu' => ['required', 'string', 'max:255', Rule::unique(SubMenu::class)],
        ]);

        try {
            $mainMenuID = Crypt::decrypt($this->mainMenuID);

            $mainMenu = $this->getMainMenu_ByID($mainMenuID);

            DB::transaction(function () use ($mainMenuID, $mainMenu) {
                $infoSubMenu = [
                    'main_menu_id' => $mainMenuID,
                    'subMenu' => ucwords($this->subMenu),
                    'subURI' => strtolower(str_replace(' ', '-', $this->subMenu)),
                ];

                SubMenu::create($infoSubMenu);

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
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $subMenu = $this->getSubMenu_ByID($id);
        $this->subMenu = $subMenu->subMenu;
    }

    public function updateSubMenu()
    {
        try {
            $mainMenuID = Crypt::decrypt($this->mainMenuID);
            $subMenuID = Crypt::decrypt($this->subMenuID);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $this->validate([
            'subMenu' => ['required', 'string', 'max:255', Rule::unique(SubMenu::class)->ignore($subMenuID)],
        ]);

        $infoSubMenu = [
            'subMenu' => ucwords($this->subMenu),
            'subURI' => strtolower(str_replace(' ', '-', $this->subMenu)),
        ];

        $mainMenu = $this->getMainMenu_ByID($mainMenuID);
        $subMenu = $this->getSubMenu_ByID($subMenuID);

        $log = [];
        $log['action'] = "Updated Sub Menu";
        $log['content'] = "Sub Menu: " . ucwords($subMenu->subMenu) . ', Main Menu: ' . $mainMenu->mainMenu;
        $log['changes'] =  "Sub Menu: " . ucwords($this->subMenu);

        $que = SubMenu::where('id', $subMenuID)
            ->update($infoSubMenu);

        if ($que) {
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
        try {
            $mainMenuID = Crypt::decrypt($this->mainMenuID);
            $subMenuID = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $subMenu = SubMenu::where('id', $subMenuID)->first();
        $subMenuCount = SubMenu::where('isEnabled', true)
            ->where('main_menu_id', $mainMenuID)
            ->count();

        if ($subMenu->isEnabled) {
            if ($subMenuCount == 1) {
                $this->getSubMenus();
                return;
            }

            SubMenu::where('id', $subMenuID)
                ->update([
                    'isEnabled' => false,
                ]);

            $log = [];
            $log['action'] = "Changed Sub Menu Status";
            $log['content'] = "Sub Menu: " . ucwords($subMenu->subMenu) . ", Sub Menu Status: Enabled";
            $log['changes'] = "Sub Menu Status: Disabled";

            UserActivityController::store($log);
        } else {
            SubMenu::where('id', $subMenuID)
                ->update([
                    'isEnabled' => true,
                ]);

            $log = [];
            $log['action'] = "Changed Sub Menu Status";
            $log['content'] = "Sub Menu: " . ucwords($subMenu->subMenu) . ", Sub Menu Status: Disabled";
            $log['changes'] = "Sub Menu Status: Enabled";

            UserActivityController::store($log);
        }
        $this->getSubMenus();
    }
}
