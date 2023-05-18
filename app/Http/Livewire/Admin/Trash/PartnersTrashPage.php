<?php

namespace App\Http\Livewire\Admin\Trash;

use App\Models\Partner;
use Livewire\Component;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\Storage;

class PartnersTrashPage extends Component
{
    public $selected;

    protected $listeners = ['permanentDeletePartner'];

    private function getPartners()
    {
        $data = array();
        $trashed = Partner::onlyTrashed()->orderBy('deleted_at')->get();
        foreach ($trashed as $trash) {
            array_push($data, [
                'id' => $trash->id,
                'name' => $trash->name,
                'URL' => $trash->URL,
                'image' => $trash->image,
                'deleted_at' => date('M-d-Y h:i A', strtotime($trash->deleted_at)),
            ]);
        }
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.trash.partners-trash-page', [
            'partners' => $this->getPartners(),
        ]);
    }

    private function getPartnerByID($id)
    {
        return Partner::withTrashed()->where('id', $id)->first();
    }

    public function restoreSeleted($id)
    {
        $partner = $this->getPartnerByID($id);
        $partner->restore();

        $log = [];
        $log['action'] = "Restored Partner";
        $log['content'] =  $log['content'] = "Name: " . $partner->name . ", URL: " . $partner->URL;
        $log['changes'] = "";
        UserActivityController::store($log);
        $this->dispatchBrowserEvent('restore-selected', [
            'title' => 'Selected partner has been restored.',
        ]);
    }

    public function deleteSelected($id)
    {
        $this->selected = $id;
        $this->dispatchBrowserEvent('permanent-delete', [
            'args' => 'partner-trash',
            'title' => 'Are You Sure?',
            'text' => 'Warning! This action is permanent and won\'t be undone. This partner will be permanently deleted.',
        ]);
    }

    public function permanentDeletePartner()
    {
        $partner = Partner::withTrashed()->findOrFail($this->selected);
        $partner->forceDelete();

        Storage::disk('public')->delete($partner->image);

        $log = [];
        $log['action'] = "Permanently Deleted Partner";
        $log['content'] =  $log['content'] = "Name: " . $partner->name . ", URL: " . $partner->URL;
        $log['changes'] = "";
        UserActivityController::store($log);

        $this->dispatchBrowserEvent('deleted-permanently', [
            'title' => 'Selected partner has been permanently deleted.',
        ]);
    }
}
