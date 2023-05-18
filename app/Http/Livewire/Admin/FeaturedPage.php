<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\UserActivityController;
use App\Models\Menu\Content;
use Livewire\Component;

class FeaturedPage extends Component
{
    private function getContents()
    {
        return Content::whereNot(function ($query) {
            $query->where('status', 'pending')
                ->orWhere('isVisible', 0);
        })->orderBy('isVisibleHome', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.featured-page', [
            'contents' => $this->getContents(),
        ])->extends('layouts.app')
            ->section('content');
    }

    private function getContentByID($id)
    {
        return Content::where('id', $id)->first();
    }

    public function toggleVisibilityStatus($id)
    {
        $content = $this->getContentByID($id);

        $log = [];
        $log['action'] = "Changed Featured Visibility";

        if ($content->isVisibleHome === 0) {
            if (!(Content::where('isVisibleHome', 1)->count() === 8)) {
                Content::where('id', $id)
                    ->update([
                        'isVisibleHome' => true,
                    ]);

                $log['content'] = "Title: " . $content->title;
                $log['changes'] = "Status: Added to Featured.";
                UserActivityController::store($log);
            } else {
                $this->dispatchBrowserEvent('swal-modal', [
                    'title' => 'Maximum featured count reached.'
                ]);
            }
        } else {
            Content::where('id', $id)
                ->update([
                    'isVisibleHome' => false,
                ]);

            $log['content'] = "Title: " . $content->title;
            $log['changes'] = "Status: Removed from Featured.";
            UserActivityController::store($log);
        }
    }
}
