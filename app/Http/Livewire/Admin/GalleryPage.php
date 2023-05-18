<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\Storage;

class GalleryPage extends Component
{
    use WithFileUploads;

    public $image, $selectedImage;

    protected $listeners = ['deleteSelectedImage'];

    protected function rules()
    {
        return [
            'image' => ['required', 'image', 'max:2048', 'mimes:png,jpg'],
        ];
    }

    private function getImages()
    {
        return Storage::disk('public')->allFiles('gallery');
    }

    private function getImagesCount()
    {
        return count(Storage::disk('public')->allFiles('gallery'));
    }

    public function render()
    {
        return view('livewire.admin.gallery-page', [
            'images' => $this->getImages(),
            'count' => $this->getImagesCount(),
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

        $image = $this->image->storeAs('gallery', $imageFileName, 'public');

        $log = [];
        $log['action'] = "Added New Gallery Image";
        $log['content'] = "Image File: " . $imageFileName;
        $log['changes'] = "";

        UserActivityController::store($log);

        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'saved',
            'message' => 'New Image Added Successfully.',
        ]);
        $this->closeModal('#modalAddIntoGallery');
    }

    public function deleteImage($image)
    {
        $this->selectedImage = $image;
        $this->dispatchBrowserEvent('delete-selected', [
            'title' => 'Are you sure?',
            'text' => 'Warning! The selected image will be permanently deleted. This action won\'t be undone.',
        ]);
    }

    public function deleteSelectedImage()
    {
        Storage::disk('public')->delete($this->selectedImage);

        $log = [];
        $log['action'] = "Deleted Gallery Image";
        $log['content'] = "Image File: " . $this->selectedImage;
        $log['changes'] = "";

        UserActivityController::store($log);

        $this->dispatchBrowserEvent('swal-modal', [
            'title' => 'deleted-selected',
            'message' => 'Image deleted successfully.',
        ]);
    }
}
