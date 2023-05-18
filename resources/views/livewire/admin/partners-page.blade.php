@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

<div>
    @section('title', 'Partners')
    @section('page-header', 'Partners')

    <div class="row">
        <div class="col-md-9">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalAddPartner"><i
                                class="fas fa-plus"></i> Add New</button>
                        <table class="table table-responsive-sm" id="">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($partners)
                                    @foreach ($partners as $key => $partner)
                                        <tr>
                                            <td>
                                                {{ $partner['name'] }}
                                            </td>
                                            <td>
                                                <a href="{{ $partner['URL'] }}">{{ $partner['URL'] }}</a>
                                            </td>
                                            <td>
                                                <img src="{{ Storage::url($partner['image']) }}" alt="Logo"
                                                    class="img-fluid" width="250">
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditPartner"
                                                    wire:click="edit('{{ $partner['id'] }}')"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                                <button class="btn btn-danger"
                                                    wire:click="deleteSelected('{{ $partner['id'] }}')">Delete</button>
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

    <div wire:ignore.self class="modal fade" id="modalAddPartner" tabindex="-1" role="dialog"
        aria-labelledby="modalAddPartner" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Partner</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" required
                                    wire:model.lazy="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">URL</label>
                                <input type="url" class="form-control @error('URL') is-invalid @enderror" required
                                    wire:model.lazy="URL">
                                @error('URL')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose Logo *</label>
                                <input type="file" wire:model="image"
                                    class="form-control @error('image') is-invalid @enderror" wire:click="resetImage">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                @if (!$errors->get('image'))
                                    @if ($image)
                                        <label class="form-label mb-1">Image Preview</label> <br>
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddPartner')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditPartner" tabindex="-1" role="dialog"
        aria-labelledby="modalEditPartner" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Partner</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('put')

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    required wire:model.lazy="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">URL</label>
                                <input type="url" class="form-control @error('URL') is-invalid @enderror" required
                                    wire:model.lazy="URL">
                                @error('URL')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose Logo *</label>
                                <input type="file" wire:model="image"
                                    class="form-control @error('image') is-invalid @enderror" wire:click="resetImage">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                @if (!$errors->get('image'))
                                    @if ($image)
                                        <label class="form-label mb-1">Cover Image Preview</label> <br>
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditPartner')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @livewireScripts
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        window.addEventListener('close-modal', event => {
            $(event.detail.modal_id).modal('hide');
        });

        window.addEventListener('swal-modal', event => {
            if (event.detail.title == 'saved') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: event.detail.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else if (event.detail.title == 'error') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: event.detail.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else if (event.detail.title == 'deleted-selected') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: event.detail.message,
                    showConfirmButton: false,
                    timer: 1500
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
                    Livewire.emit('deleteSelectedPartner');
                }
            });
        });
    </script>
@endsection
