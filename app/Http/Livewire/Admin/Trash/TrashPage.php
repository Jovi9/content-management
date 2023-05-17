<?php

namespace App\Http\Livewire\Admin\Trash;

use App\Http\Controllers\UserActivityController;
use App\Models\Menu\Content;
use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class TrashPage extends Component
{
    public function render()
    {
        return view('livewire.admin.trash.trash-page')
            ->extends('layouts.app')
            ->section('content');
    }
}
