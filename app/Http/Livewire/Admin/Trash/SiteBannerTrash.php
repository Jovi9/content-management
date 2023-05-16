<?php

namespace App\Http\Livewire\Admin\Trash;

use Livewire\Component;
use App\Models\Options\SiteBanner;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\Storage;

class SiteBannerTrash extends Component
{
    public $selected, $arg;

    protected $listeners = ['permanentDeleteSelected'];

    private function getBanners()
    {
        $banners = array();

        $trashed = SiteBanner::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        foreach ($trashed  as $trash) {
            array_push($banners, [
                'id' => $trash->id,
                'title' => $trash->title,
                'shortDesc' => $trash->shortDesc,
                'image' => $trash->image,
                'deleted_at' => date('M-d-Y h:i A', strtotime($trash->deleted_at)),
            ]);
        }
        return $banners;
    }

    public function render()
    {
        return view('livewire.admin.trash.site-banner-trash', [
            'banners' => $this->getBanners(),
        ]);
    }

    private function getBannerByID($id)
    {
        return SiteBanner::withTrashed()->where('id', $id)->first();
    }

    public function restoreSeleted($id)
    {
        $banner = $this->getBannerByID($id);
        $banner->restore();

        $log = [];
        $log['action'] = "Restored Site Banner";
        $log['content'] = "Title: " . $banner->title;
        $log['changes'] = "";
        UserActivityController::store($log);
        $this->dispatchBrowserEvent('restore-selected', [
            'title' => 'Selected site banner has been restored.',
        ]);
    }

    public function deleteSelected($id)
    {
        $this->selected = $id;
        $this->dispatchBrowserEvent('permanent-delete', [
            'title' => 'Are You Sure?',
            'text' => 'Warning! This action is permanent and won\'t be undone. This banner will be permanently deleted.',
        ]);
    }

    public function permanentDeleteSelected()
    {
        $banner = SiteBanner::withTrashed()->findOrFail($this->selected);
        $banner->forceDelete();

        Storage::disk('public')->delete($banner->image);

        $log = [];
        $log['action'] = "Permanently Deleted Site Banner";
        $log['content'] = "Title: " . $banner->title;
        $log['changes'] = "";
        UserActivityController::store($log);

        $this->dispatchBrowserEvent('deleted-permanently', [
            'title' => 'Selected site banner has been permanently deleted.',
        ]);
    }
}
