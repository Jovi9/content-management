<?php

namespace App\Http\Livewire\Admin\Options;

use App\Http\Livewire\LiveForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class SiteBanner extends LiveForm
{
    use WithFileUploads;

    public $banner;

    protected function rules()
    {
        return [
            'banner' => ['required', 'image', 'max:1024', 'mimes:png,jpg'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.options.site-banner');
    }

    public function update()
    {
        $this->validate();
        $this->banner->storeAs('logo', 'site_banner.png', 'public');
        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'Site Banner Updated Successfully.',
            'reload' => true,
        ]);
        $this->closeModal('#modalChangeBanner');
    }

    public function resetBanner()
    {
        $this->reset();
    }
}
