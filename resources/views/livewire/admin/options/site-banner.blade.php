<div>
    @if (!(count($banners) === 3))
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddBanner">Add Banner</button>
    @endif
    <div class="mb-3">
        <table class="table table-responsive-sm" id="">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Short Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($banners)
                    @foreach ($banners as $banner)
                        <tr>
                            <td>{{ ucwords($banner['title']) }}</td>
                            <td>{{ $banner['shortDesc'] }}</td>
                            <td>
                                <img src="{{ Storage::url($banner['image']) }}" alt="Image" class="img-fluid"
                                    width="250">
                            </td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditBanner"
                                    wire:click="edit('{{ $banner['id'] }}')"><i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalChangeImage"
                                    wire:click="changeImage('{{ $banner['id'] }}')"><i class="fa fa-edit"></i> Change
                                    Image</button>
                                <button class="btn btn-danger"
                                    wire:click="deleteBanner('{{ $banner['id'] }}')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div wire:ignore.self class="modal fade" id="modalAddBanner" tabindex="-1" role="dialog"
        aria-labelledby="modalAddBanner" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Site Banner</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" required
                                    wire:model.lazy="title">
                                <p><i>Note: Title must not exceed 80 characters.</i></p>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Short Description *</label>
                                <textarea class="form-control @error('shortDesc') is-invalid @enderror" cols="30" rows="6" required
                                    wire:model.lazy="shortDesc"></textarea>
                                <p><i>Note: Short description must not exceed 255 characters.</i></p>
                                @error('shortDesc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose Cover Image *</label>
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
                            wire:click="closeModal('#modalAddBanner')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditBanner" tabindex="-1" role="dialog"
        aria-labelledby="modalEditBanner" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Site Banner</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" required
                                    wire:model.lazy="title">
                                <p><i>Note: Title must not exceed 80 characters.</i></p>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Short Description *</label>
                                <textarea class="form-control @error('shortDesc') is-invalid @enderror" cols="30" rows="6" required
                                    wire:model.lazy="shortDesc"></textarea>
                                <p><i>Note: Short description must not exceed 255 characters.</i></p>
                                @error('shortDesc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditBanner')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalChangeImage" tabindex="-1" role="dialog"
        aria-labelledby="modalChangeImage" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Site Banner</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="updateImage" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                @if ($currentImage)
                                    <label class="form-label mb-1">Cover Image</label> <br>
                                    <img src="{{ Storage::url($currentImage) }}" class="img-fluid">
                                @endif
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose Cover Image *</label>
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
                            wire:click="closeModal('#modalChangeImage')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
