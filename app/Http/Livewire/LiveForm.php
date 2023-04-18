<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LiveForm extends Component
{
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function formmReset()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function closeModal($modal_id)
    {
        $this->formmReset();
        $this->dispatchBrowserEvent('close-modal', ['modal_id' => $modal_id]);
    }
}
