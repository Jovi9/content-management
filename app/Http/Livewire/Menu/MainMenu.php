<?php

namespace App\Http\Livewire\Menu;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Modal\ModalWire;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu\MainMenu as MenuMainMenu;

class MainMenu extends ModalWire
{
    protected $menus;
    public $menuID, $mainMenu;

    protected function rules()
    {
        return [
            'mainMenu' => ['required', 'string', 'max:255', Rule::unique(MenuMainMenu::class, 'main_menu')],
        ];
    }

    protected $messages = [
        'mainMenu.unique' => 'This menu has already been added.',
    ];

    //get all menus
    protected function fetchMenus()
    {
        $this->menus = DB::table('main_menus')->get();
    }

    public function render()
    {
        $this->fetchMenus();

        return view('livewire.menu.main-menu', [
            'menus' => $this->menus
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
            MenuMainMenu::create([
                'main_menu' => ucwords($this->mainMenu)
            ]);

            // get menu id
            $menu = MenuMainMenu::where('main_menu', $this->mainMenu)
                ->first();

            // create storage directory
            $directory = $menu->id . '/';
            Storage::makeDirectory($directory);

            // update menu storage location
            MenuMainMenu::where('id', $menu->id)
                ->update([
                    'location' => $directory
                ]);
        });

        $this->resetForm();

        $this->fetchMenus();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'New Menu Successfully Added.'
        ]);
    }

    public function switchStatus($id)
    {
        $menu = MenuMainMenu::where('id', $id)->first();

        if ($menu->status == "enabled") {
            MenuMainMenu::where('id', $id)
                ->update([
                    'status' => 'disabled'
                ]);
        } else {
            MenuMainMenu::where('id', $id)
                ->update([
                    'status' => 'enabled'
                ]);
        }
    }

    public function editMenu($id)
    {
        $menu = MenuMainMenu::where('id', $id)->first();
        $this->menuID = $menu->id;
        $this->mainMenu = $menu->main_menu;
    }

    public function update()
    {
        $this->validate(
            [
                'mainMenu' => ['required', 'string', 'max:255', Rule::unique(MenuMainMenu::class, 'main_menu')->ignore($this->menuID)],
            ]
        );

        $query = MenuMainMenu::where('id', $this->menuID)
            ->update([
                'main_menu' => ucwords($this->mainMenu)
            ]);

        if ($query) {
            $this->resetForm();

            $this->fetchMenus();

            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'updated',
                'message' => 'Menu Successfully Updated.'
            ]);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
