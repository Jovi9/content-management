<div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditProfile"
        id="btnEditProfile" wire:click="editProfile()">Edit Profile</button>

    <div wire:ignore.self class="modal fade" id="modalEditProfile" tabindex="-1" role="dialog"
        aria-labelledby="modalEditProfile" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Profile</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf
                    @method('put')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Employee ID *</label>
                                <input type="text" class="form-control @error('employeeID') is-invalid @enderror"
                                    required wire:model.lazy="employeeID">
                                @error('employeeID')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Deparment *</label>
                                <select class="form-select @error('department_id') is-invalid @enderror" required
                                    wire:model="department_id">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ ucwords($department->departmentName) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                                    id="firstName" required wire:model.lazy="firstName">
                                @error('firstName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control @error('middleName') is-invalid @enderror"
                                    id="middleName" wire:model.lazy="middleName">
                                @error('middleName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                                    id="lastName" required wire:model.lazy="lastName">
                                @error('lastName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="prefix" class="form-label">Prefix</label>
                                <input type="text" class="form-control @error('prefix') is-invalid @enderror"
                                    id="prefix" placeholder="e.g. Jr." maxlength="5" wire:model.lazy="prefix">
                                @error('prefix')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="sex" class="form-label">Sex *</label>
                                <select id="sex" class="form-select @error('sex') is-invalid @enderror" required
                                    wire:model.lazy="sex">
                                    <option value="Male">
                                        Male</option>
                                    <option value="Female">
                                        Female</option>
                                </select>
                                @error('sex')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="dateOfBirth" class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control @error('dateOfBirth') is-invalid @enderror"
                                    id="dateOfBirth" required wire:model.lazy="dateOfBirth">
                                @error('dateOfBirth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="placeOfBirth" class="form-label">Place of Birth *</label>
                                <input type="text" class="form-control @error('placeOfBirth') is-invalid @enderror"
                                    id="placeOfBirth" required wire:model.lazy="placeOfBirth">
                                @error('placeOfBirth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="civilStatus" class="form-label">Civil Status *</label>
                                <select id="civilStatus" class="form-select @error('civilStatus') is-invalid @enderror"
                                    required wire:model="civilStatus">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced/Separated">Divorced/Separated</option>
                                    <option value="Annulled">Annulled</option>
                                    <option value="Common-law/Live-in">Common-law/Live-in</option>
                                    <option value="Unknown">Unknown</option>
                                </select>
                                @error('civilStatus')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" wire:model.lazy="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contactNo" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contactNo') is-invalid @enderror"
                                    id="contactNo" pattern="[0-9]{11}" maxlength="11" wire:model.lazy="contactNo">
                                @error('contactNo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" id="btnClose"
                            wire:click="closeModal('#modalEditProfile')">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdateProfile"
                            wire:loading.attr="disabled">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
