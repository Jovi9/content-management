<?php

namespace App\Http\Livewire\Menu;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu\SubMenu as MenuSubMenu;

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

    // gett all sub menus
    protected function fetchSubMenus()
    {
        $this->subMenus = DB::table('main_menus')
            ->join('sub_menus', 'sub_menus.main_menu_id', '=', 'main_menus.id')
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
        $this->reset();
        $this->resetValidation();
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

        $this->resetForm();

        $this->fetchSubMenus();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'New Sub Menu Successfully Added.'
        ]);
    }

    public function switchStatus($id)
    {
        $menu = MenuSubMenu::where('id', $id)->first();

        if ($menu->sub_status == "enabled") {
            MenuSubMenu::where('id', $id)
                ->update([
                    'sub_status' => 'disabled'
                ]);
        } else {
            MenuSubMenu::where('id', $id)
                ->update([
                    'sub_status' => 'enabled'
                ]);
        }
    }

    public function editMenu($id)
    {
        $menu = MenuSubMenu::where('id', $id)->first();
        $this->subMenuID = $menu->id;
        $this->mainMenuID = $menu->main_menu_id;
        $this->subMenu = $menu->sub_menu;
    }

    public function update()
    {
        $this->validate(
            [
                'subMenu' => ['required', 'string', 'max:255', Rule::unique(MenuSubMenu::class, 'sub_menu')->ignore($this->subMenuID)],
            ]
        );

        $query = MenuSubMenu::where('id', $this->subMenuID)
            ->update([
                'main_menu_id' => $this->mainMenuID,
                'sub_menu' => ucwords($this->subMenu)
            ]);

        if ($query) {
            $this->resetForm();

            $this->fetchSubMenus();

            $this->dispatchBrowserEvent('close-modal');
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
