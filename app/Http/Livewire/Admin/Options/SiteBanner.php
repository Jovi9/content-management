<?php

namespace App\Http\Livewire\Admin\Options;

use App\Http\Controllers\UserActivityController;
use App\Http\Livewire\LiveForm;
use App\Models\Options\SiteBanner as OptionsSiteBanner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SiteBanner extends LiveForm
{
    use WithFileUploads;

    public $bannerID, $title, $shortDesc, $image, $currentImage;

    protected $listeners = ['deleteSelectedBanner'];

    protected function rules()
    {
        return [
            'title' => ['required', 'string', 'max:80'],
            'shortDesc' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:1024', 'mimes:png,jpg'],
        ];
    }

    protected function getBanners()
    {
        $banners = array();

        $allBanners = OptionsSiteBanner::all();
        foreach ($allBanners as $banner) {
            array_push($banners, [
                'id' => $banner->id,
                'title' => $banner->title,
                'shortDesc' => $banner->shortDesc,
                'image' => $banner->image,
            ]);
        }
        return $banners;
    }

    private function getBannerByID($id)
    {
        return OptionsSiteBanner::where('id', $id)->first();
    }

    public function render()
    {
        return view('livewire.admin.options.site-banner', [
            'banners' => $this->getBanners(),
        ]);
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

        $image = $this->image->storeAs('site_banner', $imageFileName, 'public');

        $bannerInfo = [
            'title' => $this->title,
            'shortDesc' => $this->shortDesc,
            'image' => $image,
        ];
        $que = OptionsSiteBanner::create($bannerInfo);

        if ($que) {

            $log = [];
            $log['action'] = "Added New Site Banner";
            $log['content'] = "Title: " . $this->title . ', Short Description: ' . $this->shortDesc;
            $log['changes'] = "";

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'New Site Banner Added Successfully.',
            ]);
            $this->closeModal('#modalAddBanner');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function resetImage()
    {
        $this->reset('image');
    }

    public function edit($id)
    {
        $this->bannerID = $id;
        $banner = $this->getBannerByID($id);
        $this->title = $banner->title;
        $this->shortDesc = $banner->shortDesc;
    }

    public function update()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:80'],
            'shortDesc' => ['required', 'string', 'max:255'],
        ]);

        $banner = $this->getBannerByID($this->bannerID);

        $bannerInfo = [
            'title' => $this->title,
            'shortDesc' => $this->shortDesc,
        ];
        $que = OptionsSiteBanner::where('id', $this->bannerID)->update($bannerInfo);

        if ($que) {
            $log = [];
            $log['action'] = "Updated Site Banner";
            $log['content'] = "Title: " . $banner->title . ', Short Description: ' . $banner->shortDesc;
            $log['changes'] = "Title: " . $this->title . ', Short Description: ' . $this->shortDesc;

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Site Banner Updated Successfully.',
            ]);
            $this->closeModal('#modalEditBanner');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function changeImage($id)
    {
        $this->bannerID = $id;
        $banner = $this->getBannerByID($id);
        $this->currentImage = $banner->image;
    }

    public function updateImage()
    {
        $this->validate([
            'image' => ['required', 'image', 'max:1024', 'mimes:png,jpg'],
        ]);

        $banner = $this->getBannerByID($this->bannerID);

        $imageFileName = $this->hashImageFileName($this->image);

        $image = $this->image->storeAs('site_banner', $imageFileName, 'public');

        $que = OptionsSiteBanner::where('id', $this->bannerID)
            ->update([
                'image' => $image,
            ]);

        if ($que) {
            Storage::disk('public')->delete($banner->image);

            $log = [];
            $log['action'] = "Changed Site Banner Cover Image";
            $log['content'] = "Title: " . $banner->title;
            $log['changes'] = "";

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Site Banner Cover Image Updated Successfully.',
            ]);
            $this->closeModal('#modalChangeImage');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function deleteBanner($id)
    {
        $this->bannerID = $id;
        $this->dispatchBrowserEvent('delete-selected', [
            'title' => 'Are you sure?',
            'text' => 'Warning! The selected banner will be moved to trash.',
        ]);
    }

    public function deleteSelectedBanner()
    {
        $banner = $this->getBannerByID($this->bannerID);

        OptionsSiteBanner::destroy($this->bannerID);

        $log = [];
        $log['action'] = "Deleted Site Banner";
        $log['content'] = "Title: " . $banner->title;
        $log['changes'] = "";
        UserActivityController::store($log);

        $this->dispatchBrowserEvent('deleted-selected');
    }
}
