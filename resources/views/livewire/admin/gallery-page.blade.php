@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

<div>
    @section('title', 'Gallery')
    @section('page-header', 'Gallery')

    <div class="row">
        <div class="col-md-9">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @if (!($count === 16))
                            <button class="btn btn-primary mb-4" data-bs-toggle="modal"
                                data-bs-target="#modalAddIntoGallery"><i class="fas fa-plus"></i> Add New</button>
                        @endif
                        <table class="table table-responsive-sm" id="">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($images)
                                    @foreach ($images as $key => $imagee)
                                        <tr>
                                            <td>
                                                <img src="{{ Storage::url($imagee) }}" alt="Image" class="img-fluid"
                                                    width="250">
                                            </td>
                                            <td>
                                                {{ $imagee }}
                                            </td>
                                            <td>
                                                <button class="btn btn-danger"
                                                    wire:click="deleteImage('{{ $imagee }}')">Delete</button>
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

    <div wire:ignore.self class="modal fade" id="modalAddIntoGallery" tabindex="-1" role="dialog"
        aria-labelledby="modalAddIntoGallery" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Image</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose Image *</label>
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
                            wire:click="closeModal('#modalAddIntoGallery')">Cancel</button>
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
                    Livewire.emit('deleteSelectedImage');
                }
            });
        });
    </script>
@endsection
