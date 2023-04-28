<div>
    <div class="row">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-4">
                            <h3>Update Password</h3>
                        </div>
                    </div>
                    <form action="javascript:void(0)" wire:submit.prevent="updatePassword" method="post" novalidate>
                        @csrf
                        @method('patch')

                        <div class="row">
                            <div class="col-sm-10">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" wire:model.lazy="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-10">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" wire:model.lazy="password" required minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-10">
                                <label for="password_confirmation" class="form-label">Confirm
                                    Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" wire:model.debounce.500ms="password_confirmation"
                                    required minlength="8">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary" id="btnChangePassword">Change
                                    Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
