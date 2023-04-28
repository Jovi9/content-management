<div>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddUserType">Add</button>

    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">User Type</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ ucwords($role['roleName']) }}</td>
                    <td>
                        @if (!(Crypt::decrypt($role['id']) === 1))
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditUserType"
                                wire:click="edit('{{ $role['id'] }}')"><i class="fa fa-edit"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- add dept --}}
    <div wire:ignore.self class="modal fade" id="modalAddUserType" tabindex="-1" role="dialog"
        aria-labelledby="modalAddUserType" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add User Type</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">User Type *</label>
                                <input type="text" class="form-control @error('roleName') is-invalid @enderror"
                                    required wire:model.lazy="roleName">
                                @error('roleName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddUserType')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditUserType" tabindex="-1" role="dialog"
        aria-labelledby="modalEditUserType" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit User Type</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('put')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">User Type *</label>
                                <input type="text" class="form-control @error('roleName') is-invalid @enderror"
                                    required wire:model.lazy="roleName">
                                @error('roleName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditUserType')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
