<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\UserActivityController;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PartnersPage extends Component
{
    use WithFileUploads;

    public $partnerID, $name, $URL, $image, $currentImage;

    protected $listeners = ['deleteSelectedPartner'];

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'URL' => ['required', 'url'],
            'image' => ['required', 'image', 'max:2048', 'mimes:png,jpg'],
        ];
    }

    private function getPartners()
    {
        $data = array();

        $partners = Partner::orderBy('name')->get();
        foreach ($partners as $partner) {
            array_push($data, [
                'id' => $partner->id,
                'name' => $partner->name,
                'URL' => $partner->URL,
                'image' => $partner->image,
            ]);
        }
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.partners-page', [
            'partners' => $this->getPartners(),
        ])->extends('layouts.app')
            ->section('content');
    }

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

    public function resetImage()
    {
        $this->reset('image');
    }

    private function getPartnerByID($id)
    {
        return Partner::where('id', $id)->first();
    }

    private function hashImageFileName($image)
    {
        $hashedOrigFileName = $image->hashName();
        $newFileName = explode('.', $hashedOrigFileName);
        $fileExt = $image->extension();

        return $newFileName[0] . time() . '.' . $fileExt;
    }

    public function store()
    {
        $this->validate();

        $imageFileName = $this->hashImageFileName($this->image);

        $image = $this->image->storeAs('partners', $imageFileName, 'public');

        $partnerInfo = [
            'name' => $this->name,
            'URL' => $this->URL,
            'image' => $image,
        ];
        $que = Partner::create($partnerInfo);

        if ($que) {
            $log = [];
            $log['action'] = "Added New Partner";
            $log['content'] = "Name: " . $this->name . ", URL: " . $this->URL . ", Image: " . $image;
            $log['changes'] = "";
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'New Partner Added Successfully.',
            ]);
            $this->closeModal('#modalAddPartner');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
                'message' => 'Failed to process request, please try again.',
            ]);
        }
    }

    public function edit($id)
    {
        $this->partnerID = $id;
        $partner = $this->getPartnerByID($id);
        $this->name = $partner->name;
        $this->URL = $partner->URL;
        $this->currentImage = $partner->image;
    }

    public function update()
    {
        if ($this->image == '') {
            $image = $this->currentImage;
        } else {
            $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'URL' => ['required', 'url'],
                'image' => ['required', 'image', 'max:2048', 'mimes:png,jpg'],
            ]);

            $imageFileName = $this->hashImageFileName($this->image);
            $image = $this->image->storeAs('partners', $imageFileName, 'public');
        }

        $partner = $this->getPartnerByID($this->partnerID);

        $partnerInfo = [
            'name' => $this->name,
            'URL' => $this->URL,
            'image' => $image,
        ];
        $que = Partner::where('id', $this->partnerID)->update($partnerInfo);

        if ($que) {
            Storage::disk('public')->delete($partner->image);

            $log = [];
            $log['action'] = "Updated Partner";
            $log['content'] = "Name: " . $partner->name . ", URL: " . $partner->URL . ", Image: " . $this->currentImage;
            $log['changes'] = "Name: " . $this->name . ", URL: " . $this->URL . ", Image: " . $image;
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Partner Updated Successfully.',
            ]);
            $this->closeModal('#modalEditPartner');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
                'message' => 'Failed to process request, please try again.',
            ]);
        }
    }

    public function deleteSelected($id)
    {
        $this->partnerID = $id;
        $this->dispatchBrowserEvent('delete-selected', [
            'title' => 'Are you sure?',
            'text' => 'Warning! The selected partner will be moved to trash.',
        ]);
    }

    public function deleteSelectedPartner()
    {
        $partner = $this->getPartnerByID($this->partnerID);

        Partner::destroy($this->partnerID);

        $log = [];
        $log['action'] = "Deleted Partner";
        $log['content'] = "Name: " . $partner->name . ", URL: " . $partner->URL . ", Image: " . $partner->image;
        $log['changes'] = "";
        UserActivityController::store($log);

        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'deleted-selected',
            'message' => 'Selected partner has been deleted.',
        ]);
    }
}
