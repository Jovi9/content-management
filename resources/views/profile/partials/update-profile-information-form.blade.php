<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="employeeID" :value="__('Employee ID')" />
            <x-text-input id="employeeID" name="employeeID" type="text" class="mt-1 block w-full" :value="old('employeeID', $user->employeeID)" required autofocus autocomplete="employeeID" />
            <x-input-error class="mt-2" :messages="$errors->get('employeeID')" />
        </div>

        <div>
            <x-input-label for="firstName" :value="__('First Name')" />
            <x-text-input id="firstName" name="firstName" type="text" class="mt-1 block w-full" :value="old('firstName', $user->firstName)" required autofocus autocomplete="firstName" />
            <x-input-error class="mt-2" :messages="$errors->get('firstName')" />
        </div>

        <div>
            <x-input-label for="middleInitial" :value="__('Middle Initial')" />
            <x-text-input id="middleInitial" name="middleInitial" type="text" class="mt-1 block w-full" :value="old('middleInitial', $user->middleInitial)" autofocus autocomplete="middleInitial" />
            <x-input-error class="mt-2" :messages="$errors->get('middleInitial')" />
        </div>

        <div>
            <x-input-label for="lastName" :value="__('Last Name')" />
            <x-text-input id="lastName" name="lastName" type="text" class="mt-1 block w-full" :value="old('lastName', $user->lastName)" required autofocus autocomplete="lastName" />
            <x-input-error class="mt-2" :messages="$errors->get('lastName')" />
        </div>

        <div>
            <x-input-label for="department_id" :value="__('Department ID')" />
            <x-text-input id="department_id" name="department_id" type="text" class="mt-1 block w-full" :value="old('department_id', $user->department_id)" required autofocus autocomplete="department_id" />
            <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
