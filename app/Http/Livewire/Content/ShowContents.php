<?php

namespace App\Http\Livewire\Content;

use Livewire\Component;
use App\Models\Menu\Content;
use App\Models\Menu\SubMenu;
use App\Models\Menu\MainMenu;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserLogActivityController;

class ShowContents extends Component
{
    use WithFileUploads;

    protected $contents = array();

    public $mainMenuID, $subMenuID;

    public $title, $content, $attachment, $randomID;

    protected function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique(Content::class, 'title')],
            // 'content' => ['required', 'string'],
            'attachment' => ['required', 'mimes:pdf']
        ];
    }

    protected $messages = [
        'attachment.required' => 'Please upload file attachment.',
    ];

    public function mount($menuID, $subID)
    {
        $this->mainMenuID = $menuID;
        $this->subMenuID = $subID;
    }

    protected function fetchContents()
    {
        if ($this->subMenuID == 'none') {
            // select from content where main menu id ?
            $this->contents = Content::where('main_menu_id', $this->mainMenuID)->get();
        } else {
            // select from content where main menu id and submenu id ?
            $this->contents = Content::where('main_menu_id', $this->mainMenuID)
                ->where('sub_menu_id', $this->subMenuID)
                ->get();
        }
    }

    public function render()
    {
        $this->fetchContents();
        // rose rose
        return view('livewire.content.show-contents', [
            'contents' => $this->contents
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm()
    {
        $this->resetExcept(['mainMenuID', 'subMenuID']);
        $this->resetValidation();
        $this->randomID = rand();
    }

    public function resetAttachment()
    {
        $this->attachment = null;
    }

    public function store()
    {
        //  validate
        $this->validate();

        // set column value
        if ($this->subMenuID == 'none') {
            $this->subMenuID = 1;
        }

        $status = '';
        if (Auth::user()->user_type_id == 1) {
            $status = 'approved';
        } else {
            $status = 'pending';
        }

        $mainMenu = MainMenu::where('id', $this->mainMenuID)->first();
        $subMenu = SubMenu::where('id', $this->subMenuID)->first();

        if ($this->subMenuID == 1) {
            $fileDir = $mainMenu->location;
        } else {
            $fileDir = $subMenu->sub_location;
        }

        // check if dir exists, if not exists create dir
        if (!(Storage::exists($fileDir))) {
            // create directory
            Storage::createDirectory($fileDir);
        }
        // store uploaded file
        $fileAttachment = $this->attachment->store($fileDir);

        $contents = [
            'main_menu_id' => $this->mainMenuID,
            'sub_menu_id' => $this->subMenuID,
            'title' => $this->title,
            'attachment' => $fileAttachment,
            'status' => $status
        ];

        $query = Content::create($contents);

        $log = [];
        $log['action'] = "Uploaded Content to " . $mainMenu->main_menu;
        $log['content'] = "Title: " . $contents['title'] . ", Content: " . $contents['attachment'];
        $log['changes'] = "";

        if ($query) {
            UserLogActivityController::store($log);

            $this->resetForm();

            $this->fetchContents();

            $this->dispatchBrowserEvent('close-modal', 'add-content');
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Content of ' . $mainMenu->main_menu . ' Successfully Added.'
            ]);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
