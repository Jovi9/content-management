<div>
    <div class="mb-3">
        <img src="{{ asset('storage/logo/site_banner.png') }}" alt="BANNER" class="img-fluid">
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalChangeBanner">Change Banner</button>

    <div wire:ignore.self class="modal fade" id="modalChangeBanner" tabindex="-1" role="dialog"
        aria-labelledby="modalChangeBanner" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Change Site Banner</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Choose Banner *</label>
                                <input type="file" wire:model="banner"
                                    class="form-control @error('banner') is-invalid @enderror" wire:click="resetBanner">
                                @error('banner')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                @if (!$errors->get('banner'))
                                    @if ($banner)
                                        <label class="form-label mb-1">Banner Preview</label> <br>
                                        <img src="{{ $banner->temporaryUrl() }}" class="img-fluid">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalChangeBanner')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
