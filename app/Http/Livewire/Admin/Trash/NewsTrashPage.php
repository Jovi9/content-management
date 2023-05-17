<?php

namespace App\Http\Livewire\Admin\Trash;

use Livewire\Component;
use App\Models\NewsUpdate;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserActivityController;

class NewsTrashPage extends Component
{
    public $selected, $arg;

    protected $listeners = ['permanentDeleteNews'];

    private function getNews()
    {
        $data = array();

        $trashed = NewsUpdate::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        foreach ($trashed as $trash) {
            array_push($data, [
                'id' => $trash->id,
                'image' => $trash->image,
                'title' => $trash->title,
                'deleted_at' => date('M-d-Y h:i A', strtotime($trash->deleted_at)),
            ]);
        }
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.trash.news-trash-page', [
            'news' => $this->getNews(),
        ]);
    }

    private function getNewsByID($id)
    {
        return NewsUpdate::withTrashed()->where('id', $id)->first();
    }

    public function restoreSeleted($id)
    {
        $news = $this->getNewsByID($id);
        $news->restore();

        $log = [];
        $log['action'] = "Restored News";
        $log['content'] = "Title: " . $news->title;
        $log['changes'] = "";
        UserActivityController::store($log);
        $this->dispatchBrowserEvent('restore-selected', [
            'title' => 'Selected news has been restored.',
        ]);
    }

    public function deleteSelected($id)
    {
        $this->selected = $id;
        $this->dispatchBrowserEvent('permanent-delete', [
            'args'=>'news-trash',
            'title' => 'Are You Sure?',
            'text' => 'Warning! This action is permanent and won\'t be undone. This news will be permanently deleted.',
        ]);
    }

    public function permanentDeleteNews()
    {
        $news = NewsUpdate::withTrashed()->findOrFail($this->selected);
        $news->forceDelete();

        Storage::disk('public')->delete($news->image);

        $log = [];
        $log['action'] = "Permanently Deleted News";
        $log['content'] = "Title: " . $news->title;
        $log['changes'] = "";
        UserActivityController::store($log);

        $this->dispatchBrowserEvent('deleted-permanently', [
            'title' => 'Selected news has been permanently deleted.',
        ]);
    }
}
