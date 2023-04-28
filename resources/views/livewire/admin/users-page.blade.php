<div>

    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalAddUser">Add
        User</button>

    <div class="">
        <table class="table table-responsive-sm" id="">
            <thead>
                <tr>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($users)
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user['employeeID'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['department'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        @if ($user['status']) checked @endif>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">
                                        @if ($user['status'])
                                            {{ __('Enabled') }}
                                        @else
                                            {{ __('Disabled') }}
                                        @endif
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditUser"
                                    wire:click="edit('{{ $user['id'] }}')"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- modals --}}
    {{-- add usr --}}
    <div wire:ignore.self class="modal fade" id="modalAddUser" tabindex="-1" role="dialog"
        aria-labelledby="modalAddUser" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add User</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <a href="{{ route('admin.options-index') }}" target="_blank"><label
                                        class="form-label">User Type
                                        *</label></a>
                                <select class="form-select @error('user_type') is-invalid @enderror" required
                                    wire:model="user_type">
                                    <option value="" selected>Select User Type</option>
                                    @foreach ($userTypes as $userType)
                                        <option value="{{ $userType->name }}">
                                            {{ ucwords($userType->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
                                <a href="{{ route('admin.options-index') }}" target="_blank"><label
                                        class="form-label">Deparment
                                        *</label></a>
                                <select class="form-select @error('department_id') is-invalid @enderror" required
                                    wire:model="department_id">
                                    <option value="" selected>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ ucwords($department->departmentName) }}
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
                                    <option value="">Select Sex</option>
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
                                <input type="text"
                                    class="form-control @error('placeOfBirth') is-invalid @enderror"
                                    id="placeOfBirth" required wire:model.lazy="placeOfBirth">
                                @error('placeOfBirth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="civilStatus" class="form-label">Civil Status *</label>
                                <select id="civilStatus"
                                    class="form-select @error('civilStatus') is-invalid @enderror" required
                                    wire:model="civilStatus">
                                    <option value="">Select Civil Status</option>
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
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddUser')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit user --}}
    <div wire:ignore.self class="modal fade" id="modalEditUser" tabindex="-1" role="dialog"
        aria-labelledby="modalEditUser" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit User</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('put')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <a href="{{ route('admin.options-index') }}" target="_blank"><label
                                        class="form-label">User Type
                                        *</label></a>
                                <select class="form-select @error('user_type') is-invalid @enderror" required
                                    wire:model="user_type">
                                    @foreach ($userTypes as $userType)
                                        <option value="{{ $userType->name }}">
                                            {{ ucwords($userType->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
                                <a href="{{ route('admin.options-index') }}" target="_blank"><label
                                        class="form-label">Deparment
                                        *</label></a>
                                <select class="form-select @error('department_id') is-invalid @enderror" required
                                    wire:model="department_id">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ ucwords($department->departmentName) }}
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
                                <select id="sex" class="form-select @error('sex') is-invalid @enderror"
                                    required wire:model.lazy="sex">
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
                                <input type="text"
                                    class="form-control @error('placeOfBirth') is-invalid @enderror"
                                    id="placeOfBirth" required wire:model.lazy="placeOfBirth">
                                @error('placeOfBirth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="civilStatus" class="form-label">Civil Status *</label>
                                <select id="civilStatus"
                                    class="form-select @error('civilStatus') is-invalid @enderror" required
                                    wire:model="civilStatus">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditUser')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update
                            User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
