<div>
    <div class="container-fluid">
        <div class="mb-3">
            <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO" class="img-fluid" width="25%">
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalChangeLogo">Change Logo</button>

        <div wire:ignore.self class="modal fade" id="modalChangeLogo" tabindex="-1" role="dialog"
            aria-labelledby="modalChangeLogo" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Update Web Logo</strong></h5>
                    </div>
                    <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                        @csrf

                        <div class="modal-body text-left">
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Choose Logo *</label>
                                    <input type="file" wire:model="logo"
                                        class="form-control @error('logo') is-invalid @enderror" wire:click="resetLogo">
                                    @error('logo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    @if (!$errors->get('logo'))
                                        @if ($logo)
                                            <label class="form-label mb-1">Logo Preview</label> <br>
                                            <img src="{{ $logo->temporaryUrl() }}" class="img-fluid">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button"
                                wire:click="closeModal('#modalChangeLogo')">Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
