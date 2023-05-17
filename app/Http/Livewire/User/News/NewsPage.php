<?php

namespace App\Http\Livewire\User\News;

use App\Http\Controllers\UserActivityController;
use App\Models\NewsUpdate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewsPage extends Component
{
    use WithFileUploads;

    public $newsID, $image, $currentImage;

    protected $listeners = ['deleteSelectedNews'];

    protected function rules()
    {
        return [
            'image' => ['required', 'image', 'max:2048', 'mimes:png,jpg'],
        ];
    }

    private function getNews()
    {
        $news = array();

        $allNews = NewsUpdate::orderBy('status', 'desc')
            ->orderBy('created_at', 'desc')->get();
        foreach ($allNews as $new) {
            $createdBy = $new->createdBy()->first();
            $updatedBy = $new->updatedBy()->first();
            array_push($news, [
                'id' => $new->id,
                'image' => $new->image,
                'title' => $new->title,
                'createdBy' => $createdBy->firstName . ' ' . $createdBy->middleName . ' ' . $createdBy->lastName . ' ' . $createdBy->prefix,
                'updatedBy' => $updatedBy->firstName . ' ' . $updatedBy->middleName . ' ' . $updatedBy->lastName . ' ' . $updatedBy->prefix,
                'created_at' => date('M-d-Y h:i A', strtotime($new->created_at)),
                'updated_at' => date('M-d-Y h:i A', strtotime($new->updated_at)),
                'status' => $new->status,
            ]);
        }
        return $news;
    }

    public function render()
    {
        return view('livewire.user.news.news-page', [
            'news' => $this->getNews(),
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

    private function getNewsByID($id)
    {
        return NewsUpdate::where('id', $id)->first();
    }

    public function approveNews($id)
    {
        $news = $this->getNewsByID($id);

        $que = NewsUpdate::where('id', $id)
            ->update([
                'status' => 'approved',
            ]);

        if ($que) {
            $log = [];
            $log['action'] = "Approved News Content";
            $log['content'] = "Title: " . $news->title;
            $log['changes'] = "";
            UserActivityController::store($log);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error',
            ]);
        }
    }

    private function hashImageFileName($image)
    {
        $hashedOrigFileName = $image->hashName();
        $newFileName = explode('.', $hashedOrigFileName);
        $fileExt = $image->extension();

        return $newFileName[0] . time() . '.' . $fileExt;
    }

    public function changeImage($id)
    {
        $this->newsID = $id;
        $news = $this->getNewsByID($id);
        $this->currentImage = $news->image;
    }

    public function updateImage()
    {
        $this->validate([
            'image' => ['required', 'image', 'max:2048', 'mimes:png,jpg'],
        ]);

        $news = $this->getNewsByID($this->newsID);

        $imageFileName = $this->hashImageFileName($this->image);

        $image = $this->image->storeAs('news', $imageFileName, 'public');

        $que = NewsUpdate::where('id', $this->newsID)
            ->update([
                'image' => $image,
            ]);

        if ($que) {
            Storage::disk('public')->delete($news->image);

            $log = [];
            $log['action'] = "Changed News Cover Image";
            $log['content'] = "Title: " . $news->title;
            $log['changes'] = "";
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'News Cover Image Updated Successfully.',
            ]);
            $this->closeModal('#modalChangeImage');
        }
    }

    public function deleteNews($id)
    {
        $this->newsID = $id;
        $this->dispatchBrowserEvent('delete-selected', [
            'title' => 'Are you sure?',
            'text' => 'Warning! The selected news will be moved to trash.',
        ]);
    }

    public function deleteSelectedNews()
    {
        $news = $this->getNewsByID($this->newsID);

        NewsUpdate::destroy($this->newsID);

        $log = [];
        $log['action'] = "Deleted News";
        $log['content'] = "Title: " . $news->title;
        $log['changes'] = "";
        UserActivityController::store($log);

        $this->dispatchBrowserEvent('deleted-selected', [
            'title' => 'Selected news has been deleted.'
        ]);
    }
}
