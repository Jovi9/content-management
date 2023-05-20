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

    protected $listeners = ['deleteMainMenu'];

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
                    'mainMenu' => $this->mainMenu,
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
            'mainMenu' => $this->mainMenu,
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

        $log = [];
        $log['action'] = "Changed Main Menu Status";

        if ($mainMenu->isEnabled) {
            MainMenu::where('id', $menuID)
                ->update([
                    'isEnabled' => false,
                ]);

            $log['content'] = "Menu Name: " . ucwords($mainMenu->mainMenu) . ", Menu Status: Enabled";
            $log['changes'] = "Menu Status: Disabled";

            UserActivityController::store($log);
        } else {
            MainMenu::where('id', $menuID)
                ->update([
                    'isEnabled' => true,
                ]);

            $log['content'] = "Menu Name: " . ucwords($mainMenu->mainMenu) . ", Menu Status: Disabled";
            $log['changes'] = "Menu Status: Enabled";

            UserActivityController::store($log);
        }
    }

    public function deleteSelected($id)
    {
        $this->mainMenuID = $id;
        $this->dispatchBrowserEvent('delete-selected', [
            'title' => 'Are you sure?',
            'text' => 'Warning! This action will move all its Sub Menus and Contents to trash.',
        ]);
    }

    public function deleteMainMenu()
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

        $subMenus = array();
        $allSubMenu = $mainMenu->subMenus()->get();
        foreach ($allSubMenu as $subMenu) {
            array_push($subMenus, [
                'Sub Menu' => $subMenu->subMenu,
            ]);
        }

        $contents = array();
        $allContents = $mainMenu->contents()->get();
        foreach ($allContents as $content) {
            array_push($contents, [
                'Title' => $content->title,
            ]);
        }

        $mainMenu->delete();
        $mainMenu->subMenus()->delete();
        $mainMenu->contents()->delete();

        $log = [];
        $log['action'] = "Deleted Main Menu";
        $log['content'] = "Main Menu: " . $mainMenu->mainMenu . ', ' . json_encode($subMenus) . ", Contents: " . json_encode($contents);
        $log['changes'] = "";
        UserActivityController::store($log);
    }

    // sub menu
    public function addSubMenu($id)
    {
        $this->mainMenuID = $id;
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
                    'subMenu' => $this->subMenu,
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
}
