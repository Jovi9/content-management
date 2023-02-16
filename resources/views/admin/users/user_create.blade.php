<x-app-layout>
    @section('title', 'Add New User')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('admin.users.store') }}" class="p-6">
                        @csrf

                        <div class="">
                            <div>
                                <x-input-label for="employeeID" :value="__('Employee ID')" />
                                <x-text-input id="employeeID" name="employeeID" type="text" class="mt-1 block w-full"
                                    :value="old('employeeID')" required autofocus autocomplete="employeeID" />
                                <x-input-error class="mt-2" :messages="$errors->get('employeeID')" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="firstName" :value="__('First Name')" />
                                <x-text-input id="firstName" name="firstName" type="text" class="mt-1 block w-full"
                                    :value="old('firstName')" required autofocus autocomplete="firstName" />
                                <x-input-error class="mt-2" :messages="$errors->get('firstName')" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="middleInitial" :value="__('Middle Initial')" />
                                <x-text-input id="middleInitial" name="middleInitial" type="text"
                                    class="mt-1 block w-full" :value="old('middleInitial')" autofocus
                                    autocomplete="middleInitial" />
                                <x-input-error class="mt-2" :messages="$errors->get('middleInitial')" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="lastName" :value="__('Last Name')" />
                                <x-text-input id="lastName" name="lastName" type="text" class="mt-1 block w-full"
                                    :value="old('lastName')" required autofocus autocomplete="lastName" />
                                <x-input-error class="mt-2" :messages="$errors->get('lastName')" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="department_id" :value="__('Department ID')" />
                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    name="department_id" id="department_id" value={{ old('department_id') }} required>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ Str::ucfirst($department->departmentName) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email')" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="user_type" :value="__('User Type')" />

                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    name="user_type" id="user_type" value={{ old('user_type') }} required>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ Str::ucfirst($type->userTypeName) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_type')" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.users.index') }}">
                                <x-secondary-button>
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                            </a>

                            <x-primary-button class="ml-3">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
