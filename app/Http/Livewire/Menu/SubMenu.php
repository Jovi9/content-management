<?php

namespace App\Http\Livewire\Menu;

use Livewire\Component;
use App\Models\Menu\MainMenu;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu\SubMenu as MenuSubMenu;
use App\Http\Controllers\UserLogActivityController;

class SubMenu extends Component
{
    protected $subMenus, $mainMenus;

    public $subMenuID, $mainMenuID = "", $subMenu;

    protected function rules()
    {
        return [
            'mainMenuID' => ['required', 'integer'],
            'subMenu' => ['required', 'string', 'max:255', Rule::unique(MenuSubMenu::class, 'sub_menu')],
        ];
    }

    protected $messages = [
        'subMenu.unique' => 'This sub menu has already been added.',
    ];

    public function mount($mainMenuID)
    {
        $this->mainMenuID = $mainMenuID;
    }

    // gett all sub menus
    protected function fetchSubMenus()
    {
        $this->subMenus = DB::table('main_menus')
            ->join('sub_menus', 'sub_menus.main_menu_id', '=', 'main_menus.id')
            ->where('main_menus.id', '=', $this->mainMenuID)
            ->get();
    }

    protected function fetchMainMenus()
    {
        $this->mainMenus =  DB::table('main_menus')
            ->whereNot('main_menu', '=', 'Home')
            ->whereNot('main_menu', '=', 'About')
            ->whereNot('main_menu', '=', 'Contact Us')
            ->get();
    }

    public function render()
    {
        $this->fetchSubMenus();
        $this->fetchMainMenus();

        return view('livewire.menu.sub-menu', [
            'subMenus' => $this->subMenus,
            'mainMenus'  => $this->mainMenus
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm()
    {
        $this->reset('subMenuID');
        $this->reset('subMenu');
        $this->resetValidation();
    }

    protected function getSubMenu_ByID($id)
    {
        return MenuSubMenu::where('id', $id)->first();
    }

    protected function getMainMenu_ByID($id)
    {
        return MainMenu::where('id', $id)->first();
    }

    public function store()
    {
        $this->validate();

        // transac for saving new menu
        DB::transaction(function () {

            // save menu
            MenuSubMenu::create([
                'main_menu_id' => $this->mainMenuID,
                'sub_menu' => ucwords($this->subMenu)
            ]);

            // get menu id
            $menu = MenuSubMenu::where('sub_menu', $this->subMenu)
                ->first();

            // create storage directory
            $directory = $this->mainMenuID . '/' . $menu->id . '/';
            Storage::makeDirectory($directory);

            // update menu storage location
            MenuSubMenu::where('id', $menu->id)
                ->update([
                    'sub_location' => $directory
                ]);
        });

        $mainMenu = $this->getMainMenu_ByID($this->mainMenuID);

        $log = [];
        $log['action'] = "Added New Sub Menu";
        $log['content'] = "Sub Menu: " . ucwords($this->subMenu) . ', Main Menu: ' . $mainMenu->main_menu;
        $log['changes'] = '';

        UserLogActivityController::store($log);

        $this->resetForm();

        $this->fetchSubMenus();

        $this->dispatchBrowserEvent('close-modal', 'add-sub-menu');
        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'New Sub Menu Successfully Added.'
        ]);
    }

    public function switchStatus($id)
    {
        $menu = $this->getSubMenu_ByID($id);

        if ($menu->sub_status == "enabled") {
            MenuSubMenu::where('id', $id)
                ->update([
                    'sub_status' => 'disabled'
                ]);

            $log = [];
            $log['action'] = "Changed Sub Menu Status";
            $log['content'] = "Sub Menu: " . $menu->sub_menu . ", Sub Menu Status: " . ucfirst($menu->sub_status);
            $log['changes'] = "Sub Menu Status: Disabled";

            UserLogActivityController::store($log);
        } else {
            MenuSubMenu::where('id', $id)
                ->update([
                    'sub_status' => 'enabled'
                ]);

            $log = [];
            $log['action'] = "Changed Sub Menu Status";
            $log['content'] = "Sub Menu: " . $menu->sub_menu . ", Sub Menu Status: " . ucfirst($menu->sub_status);
            $log['changes'] = "Sub Menu Status: Enabled";

            UserLogActivityController::store($log);
        }
    }

    public function editMenu($id)
    {
        $menu = $this->getSubMenu_ByID($id);
        $this->subMenuID = $menu->id;
        // $this->mainMenuID = $menu->main_menu_id;
        $this->subMenu = $menu->sub_menu;
    }

    public function update()
    {
        $this->validate(
            [
                'mainMenuID' => ['required', 'integer'],
                'subMenu' => ['required', 'string', 'max:255', Rule::unique(MenuSubMenu::class, 'sub_menu')->ignore($this->subMenuID)],
            ]
        );

        $subMenu = $this->getSubMenu_ByID($this->subMenuID);

        $query = MenuSubMenu::where('id', $this->subMenuID)
            ->update([
                'main_menu_id' => $this->mainMenuID,
                'sub_menu' => ucwords($this->subMenu)
            ]);

        $mainMenu = $this->getMainMenu_ByID($this->mainMenuID);

        $log = [];
        $log['action'] = "Updated Sub Menu";
        $log['content'] = "Sub Menu: " . ucwords($subMenu->sub_menu) . ', Main Menu: ' . $mainMenu->main_menu;
        $log['changes'] =  "Sub Menu: " . ucwords($this->subMenu) . ', Main Menu: ' . $mainMenu->main_menu;;

        if ($query) {
            UserLogActivityController::store($log);

            $this->resetForm();

            $this->fetchSubMenus();

            $this->dispatchBrowserEvent('close-modal', 'edit-sub-menu');
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'updated',
                'message' => 'Sub Menu Successfully Updated.'
            ]);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
