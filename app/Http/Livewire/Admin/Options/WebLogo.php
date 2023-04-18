<?php

namespace App\Http\Livewire\Admin\Options;

use App\Http\Livewire\LiveForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class WebLogo extends LiveForm
{
    use WithFileUploads;

    public $logo;

    protected function rules()
    {
        return [
            'logo' => ['required', 'image', 'max:1024', 'mimes:png'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.options.web-logo');
    }

    public function update()
    {
        $this->validate();
        $this->logo->storeAs('logo', 'sys_logo.png', 'public');
        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'Web Logo Updated Successfully.',
            'reload' => true,
        ]);
        $this->closeModal('#modalChangeLogo');
    }

    public function resetLogo()
    {
        $this->reset();
    }
}
