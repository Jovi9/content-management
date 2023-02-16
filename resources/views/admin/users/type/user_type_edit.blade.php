<x-app-layout>
    @section('title', 'Edit User Type')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-sm mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('admin.user_types.update', ['user_type' => $userType->id]) }}"
                        class="p-6">
                        @csrf
                        @method('put')

                        <div class="">
                            <div class="mt-4">
                                <x-input-label for="userTypeName" :value="__('User Type')" />
                                <x-text-input id="userTypeName" name="userTypeName" type="text"
                                    class="mt-1 block w-full" :value="old('userTypeName', $userType->userTypeName)" required autofocus
                                    autocomplete="userTypeName" />
                                <x-input-error class="mt-2" :messages="$errors->get('userTypeName')" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.users.index') }}">
                                <x-secondary-button>
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                            </a>

                            <x-primary-button class="ml-3">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
