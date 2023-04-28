<div>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddDepartment">Add</button>

    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">Department Name</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ ucwords($department['departmentName']) }}</td>
                    <td>{{ $department['departmentDescription'] }}</td>
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditDepartment"
                            wire:click="edit('{{ $department['id'] }}')"><i class="fa fa-edit"></i></button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- add dept --}}
    <div wire:ignore.self class="modal fade" id="modalAddDepartment" tabindex="-1" role="dialog"
        aria-labelledby="modalAddDepartment" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Department</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Department Name *</label>
                                <input type="text" class="form-control @error('departmentName') is-invalid @enderror"
                                    required wire:model.lazy="departmentName">
                                @error('departmentName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('departmentDescription') is-invalid @enderror" required
                                    wire:model.lazy="departmentDescription" rows="5"></textarea>
                                @error('departmentDescription')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddDepartment')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditDepartment" tabindex="-1" role="dialog"
        aria-labelledby="modalEditDepartment" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Department</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('put')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Department Name *</label>
                                <input type="text" class="form-control @error('departmentName') is-invalid @enderror"
                                    required wire:model.lazy="departmentName">
                                @error('departmentName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('departmentDescription') is-invalid @enderror" required
                                    wire:model.lazy="departmentDescription" rows="5"></textarea>
                                @error('departmentDescription')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditDepartment')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
