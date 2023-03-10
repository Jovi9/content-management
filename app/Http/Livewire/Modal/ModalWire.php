<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class ModalWire extends Component
{
    public bool $modalForm = false;

    protected $listeners = [
        'show' => 'openModal'
    ];

    public function openModal()
    {
        $this->modalForm = true;
    }
}
