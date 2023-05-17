@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

<div>
    @section('title', 'News')
    @section('page-header', 'News')

    <div class="bg-white p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('admin.news-create') }}" class="btn btn-primary mb-4"><i class="fas fa-add"></i> Add
                        New</a>
                    <table class="table table-responsive-sm" id="">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">User</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($news)
                                @foreach ($news as $new)
                                    <tr>
                                        <td>
                                            <img src="{{ Storage::url($new['image']) }}" alt="Image"
                                                class="img-fluid" width="250">
                                        </td>
                                        <td>{{ $new['title'] }}</td>
                                        <td>
                                            {{ __('Created By: ' . $new['createdBy']) }} <br>
                                            {{ __('Updated By: ' . $new['updatedBy']) }}
                                        </td>
                                        <td>
                                            {{ _('Date Created: ') . $new['created_at'] }} <br>
                                            {{ __('Date Updated: ') . $new['updated_at'] }}
                                        </td>
                                        <td>
                                            {{ ucwords($new['status']) }}
                                        </td>
                                        <td>
                                            @role('administrator')
                                                @if (strtolower($new['status']) == 'pending')
                                                    <button class="btn btn-primary"
                                                        wire:click="approveNews('{{ $new['id'] }}')">
                                                        <i class="fa fa-check"></i></button>
                                                @endif
                                            @endrole
                                            <a href="{{ route('admin.news-edit', ['id' => $new['id']]) }}"
                                                class="btn btn-primary"><i class="fas fa-edit"></i>
                                                Edit</a>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalChangeImage"
                                                wire:click="changeImage('{{ $new['id'] }}')">
                                                <i class="fa fa-edit"></i> Change
                                                Image</button>

                                            @role('administrator')
                                                <button class="btn btn-danger"
                                                    wire:click="deleteNews('{{ $new['id'] }}')">Delete</button>
                                            @endrole
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

    <div wire:ignore.self class="modal fade" id="modalChangeImage" tabindex="-1" role="dialog"
        aria-labelledby="modalChangeImage" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Change News Cover Image</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="updateImage" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                @if ($currentImage)
                                    <label class="form-label mb-1">Image</label> <br>
                                    <img src="{{ Storage::url($currentImage) }}" class="img-fluid">
                                @endif
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose New Image *</label>
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
                                        <label class="form-label mb-1">New Image Preview</label> <br>
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalChangeImage')">Cancel</button>
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
    @if (Session::has('saved'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'News added successfully',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (Session::has('updated'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'News updated successfully',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <script>
        window.addEventListener('close-modal', event => {
            $(event.detail.modal_id).modal('hide');
        });

        window.addEventListener('swal-modal', event => {
            if (event.detail.title == "saved") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: event.detail.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (event.detail.reload == true) {
                        location.reload();
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
                    Livewire.emit('deleteSelectedNews');
                }
            });
        });

        window.addEventListener('deleted-selected', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: event.detail.title,
            });
        });
    </script>
@endsection
