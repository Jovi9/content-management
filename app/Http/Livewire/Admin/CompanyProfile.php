<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\UserActivityController;
use App\Http\Livewire\LiveForm;
use App\Models\CompanyProfile as ModelsCompanyProfile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CompanyProfile extends LiveForm
{
    protected $profile;
    public $count = '';
    public $companyName, $companyAddress, $companyHead, $companyHeadTitle, $companyType, $companyDescription, $companyEmail;

    protected function rules()
    {
        return [
            'companyName' => ['required', 'string', 'max:255'],
            'companyAddress' => ['required', 'string'],
            'companyHead' => ['required', 'string', 'max:255'],
            'companyHeadTitle' => ['required', 'string', 'max:255'],
            'companyType' => ['required', 'string', 'max:255'],
            'companyDescription' => ['required', 'string'],
            'companyEmail' => ['required', 'email', 'max:255', Rule::unique(ModelsCompanyProfile::class, 'email')],
        ];
    }

    protected function getProfile()
    {
        $this->count = Crypt::encrypt(ModelsCompanyProfile::count());;
        $this->profile = ModelsCompanyProfile::get()->first();
    }

    public function render()
    {
        $this->getProfile();
        return view('livewire.admin.company-profile', [
            'count' => $this->count,
            'profile' => $this->profile
        ]);
    }

    public function formmReset()
    {
        $this->resetExcept('count');
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        $profile = [
            'companyName' => ucwords($this->companyName),
            'companyAddress' => ucwords($this->companyAddress),
            'companyHead' => ucwords($this->companyHead),
            'companyHeadTitle' => ucwords($this->companyHeadTitle),
            'companyType' => ucwords($this->companyType),
            'companyDescription' => ucwords($this->companyDescription),
            'email' => $this->companyEmail,
        ];

        $log = [];
        $log['action'] = "Created Company Profile";
        $log['content'] = "Company Name: " . $this->companyName . ", Company Address: " . $this->companyAddress . ", Company Head: "  . $this->companyHead . ", Company Head Title: "  . $this->companyHeadTitle . ", Company Type: " . $this->companyType . ", Company Description: " . $this->companyDescription . ", Email: " . $this->companyEmail;
        $log['changes'] = '';

        $query = ModelsCompanyProfile::create($profile);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Profile Successfully Saved.',
            ]);
            $this->closeModal('#modalAddCompanyProfile');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function edit()
    {
        $comProfile = ModelsCompanyProfile::get()->first();
        $this->companyName = $comProfile->companyName;
        $this->companyAddress = $comProfile->companyAddress;
        $this->companyHead = $comProfile->companyHead;
        $this->companyHeadTitle = $comProfile->companyHeadTitle;
        $this->companyType = $comProfile->companyType;
        $this->companyDescription = $comProfile->companyDescription;
        $this->companyEmail = $comProfile->email;
    }

    public function update()
    {
        $this->validate([
            'companyName' => ['required', 'string', 'max:255'],
            'companyAddress' => ['required', 'string'],
            'companyHead' => ['required', 'string', 'max:255'],
            'companyHeadTitle' => ['required', 'string', 'max:255'],
            'companyType' => ['required', 'string', 'max:255'],
            'companyDescription' => ['required', 'string'],
            'companyEmail' => ['required', 'email', 'max:255', Rule::unique(ModelsCompanyProfile::class, 'email')->ignore(1)],
        ]);

        $profile = [
            'companyName' => ucwords($this->companyName),
            'companyAddress' => ucwords($this->companyAddress),
            'companyHead' => ucwords($this->companyHead),
            'companyHeadTitle' => ucwords($this->companyHeadTitle),
            'companyType' => ucwords($this->companyType),
            'companyDescription' => ucwords($this->companyDescription),
            'email' => $this->companyEmail,
        ];

        $comProfile = ModelsCompanyProfile::get()->first();

        $log = [];
        $log['action'] = "Updated Company Profile";
        $log['content'] = "Company Name: " . $comProfile->companyName . ", Company Address: " . $comProfile->companyAddress . ", Company Head: "  . $comProfile->companyHead . ", Company Head Title: "  . $comProfile->companyHeadTitle . ", Company Type: " . $comProfile->companyType . ", Company Description: " . $comProfile->companyDescription . ", Email: " . $comProfile->email;
        $log['changes'] = "Company Name: " . $this->companyName . ", Company Address: " . $this->companyAddress . ", Company Head: "  . $this->companyHead . ", Company Head Title: "  . $this->companyHeadTitle . ", Company Type: " . $this->companyType . ", Company Description: " . $this->companyDescription . ", Email: " . $this->companyEmail;

        $query = ModelsCompanyProfile::where('id', 1)
            ->update($profile);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Profile Successfully Updated.',
            ]);
            $this->closeModal('#modalEditCompanyProfile');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
