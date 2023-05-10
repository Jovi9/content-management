@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('scripts')
    @livewireScripts
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        window.addEventListener('close-modal', event => {
            $(event.detail.modal_id).modal('hide');
        });

        window.addEventListener('swal-modal', event => {
            if (event.detail.title == "saved") {
                Swal.fire({
                    icon: 'success',
                    title: event.detail.message,
                    confirmButtonText: 'Ok',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            } else if (event.detail.title == "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to process request.',
                    text: 'Something went wrong, please try again.',
                    allowOutsideClick: false
                });
            }
        });

        window.addEventListener('delete-selected', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteSubMenu');
                }
            })
        });
    </script>
@endsection

<div>
    @section('title', 'Sub Menus of ' . $mainMenu->mainMenu)
    @section('page-header', 'Sub Menus of ' . $mainMenu->mainMenu)
    @section('page-header-right')
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.navigations-index') }}">Web Navigations</a></li>
                <li class="breadcrumb-item active">{{ $mainMenu->mainMenu }}</li>
            </ol>
        </div>
    @endsection

    <div class="col-lg-9">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddSubMenu">
                            <i class="fa fa-plus"></i> Add New Sub Menu
                        </button>

                        <table class="table table-responsive-sm" id="">
                            <thead>
                                <tr>
                                    <th scope="col">Sub Menu</th>
                                    <th scope="col">URI</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($subMenus)
                                    @foreach ($subMenus as $subMenu)
                                        <tr>
                                            <td>{{ ucwords($subMenu['subMenu']) }}</td>
                                            <td>
                                                <a href="{{ route('public-show', ['main' => $subMenu['mainURI'] . '/' . $subMenu['subURI']]) }}"
                                                    target="_blank">
                                                    <div>
                                                        {{ '/' . $subMenu['mainURI'] . '/' . $subMenu['subURI'] }}
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $subMenu['subMenu'] }}"
                                                        @if ($subMenu['isEnabled']) checked @endif
                                                        wire:click="toggleSubMenuStatus('{{ $subMenu['id'] }}')">
                                                    <label class="form-check-label" for="{{ $subMenu['subMenu'] }}">
                                                        @if ($subMenu['isEnabled'])
                                                            {{ __('Enabled') }}
                                                        @else
                                                            {{ __('Disabled') }}
                                                        @endif
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditSubMenu"
                                                    wire:click="editSubMenu('{{ $subMenu['id'] }}')"><i
                                                        class="fa fa-edit"></i> Edit Sub Menu</button>
                                                <a href="{{ route('admin.contents-create', ['main' => $subMenu['mainURI'] . '/' . $subMenu['subURI']]) }}"
                                                    class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a>
                                                <button class="btn btn-danger"
                                                    wire:click="deleteSelected('{{ $subMenu['id'] }}')">
                                                    <i class="fa fa-trash"></i> Delete Menu
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalAddSubMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalAddSubMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Sub Menu for {{ $mainMenu->mainMenu }}</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="storeSubMenu" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Sub Menu Name *</label>
                                <input type="text" class="form-control @error('subMenu') is-invalid @enderror"
                                    required wire:model.lazy="subMenu">
                                @error('subMenu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddSubMenu')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditSubMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalEditSubMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Sub Menu of {{ $mainMenu->mainMenu }}</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="updateSubMenu" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Sub Menu Name *</label>
                                <input type="text" class="form-control @error('subMenu') is-invalid @enderror"
                                    required wire:model.lazy="subMenu">
                                @error('subMenu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditSubMenu')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
