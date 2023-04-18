<div>
    @if (Crypt::decrypt($count) === 0)
        <h2>Please add company profile first.</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCompanyProfile"
            wire:loading.attr="disabled">Add</button>
    @else
        <h1>Profile Information</h1>
        <h3 class="mt-3"><strong>Company Name: </strong>{{ $profile->companyName }}</h3>
        <h3 class="mt-3"><strong>Company Address: </strong>{{ $profile->companyAddress }}</h3>
        <h3 class="mt-3"><strong>Company Head: </strong>{{ $profile->companyHead }}</h3>
        <h3 class="mt-3"><strong>Company Head Title: </strong>{{ $profile->companyHeadTitle }}</h3>
        <h3 class="mt-3"><strong>Company Type: </strong>{{ $profile->companyType }}</h3>
        <h3 class="mt-3"><strong>Company Description: </strong>{{ $profile->companyDescription }}</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditCompanyProfile"
            wire:click="edit" wire:loading.attr="disabled">Edit</button>
    @endif

    <div wire:ignore.self class="modal fade" id="modalAddCompanyProfile" tabindex="-1" role="dialog"
        aria-labelledby="modalAddCompanyProfile" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Company Profile</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Company Name *</label>
                                <input type="text" class="form-control @error('companyName') is-invalid @enderror"
                                    required wire:model.lazy="companyName">
                                @error('companyName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Address *</label>
                                <input type="text" class="form-control @error('companyAddress') is-invalid @enderror"
                                    required wire:model.lazy="companyAddress">
                                @error('companyAddress')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Head *</label>
                                <input type="text" class="form-control @error('companyHead') is-invalid @enderror"
                                    required wire:model.lazy="companyHead">
                                @error('companyHead')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Head Title *</label>
                                <input type="text"
                                    class="form-control @error('companyHeadTitle') is-invalid @enderror" required
                                    wire:model.lazy="companyHeadTitle">
                                @error('companyHeadTitle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Type *</label>
                                <input type="text" class="form-control @error('companyType') is-invalid @enderror"
                                    required wire:model.lazy="companyType">
                                @error('companyType')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Description *</label>
                                <textarea class="form-control @error('companyDescription') is-invalid @enderror" required
                                    wire:model.lazy="companyDescription" rows="5"></textarea>
                                @error('companyDescription')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" id="btnClose"
                            wire:click="closeModal('#modalAddCompanyProfile')">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnAddCompanyProfile"
                            wire:loading.attr="disabled">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditCompanyProfile" tabindex="-1" role="dialog"
        aria-labelledby="modalEditCompanyProfile" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Company Profile</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Company Name *</label>
                                <input type="text" class="form-control @error('companyName') is-invalid @enderror"
                                    required wire:model.lazy="companyName">
                                @error('companyName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Address *</label>
                                <input type="text"
                                    class="form-control @error('companyAddress') is-invalid @enderror" required
                                    wire:model.lazy="companyAddress">
                                @error('companyAddress')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Head *</label>
                                <input type="text" class="form-control @error('companyHead') is-invalid @enderror"
                                    required wire:model.lazy="companyHead">
                                @error('companyHead')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Head Title *</label>
                                <input type="text"
                                    class="form-control @error('companyHeadTitle') is-invalid @enderror" required
                                    wire:model.lazy="companyHeadTitle">
                                @error('companyHeadTitle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Type *</label>
                                <input type="text" class="form-control @error('companyType') is-invalid @enderror"
                                    required wire:model.lazy="companyType">
                                @error('companyType')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Company Description *</label>
                                <textarea class="form-control @error('companyDescription') is-invalid @enderror" required
                                    wire:model.lazy="companyDescription" rows="5"></textarea>
                                @error('companyDescription')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" id="btnClose"
                            wire:click="closeModal('#modalEditCompanyProfile')">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnEditCompanyProfile"
                            wire:loading.attr="disabled">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
