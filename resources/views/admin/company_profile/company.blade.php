<x-app-layout>
    @section('title', 'Company Profile')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($count === 0)
                        <h2>Please add company profile first.</h2>
                        <br>
                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'add-company-profile')">
                            {{ _('Add Company Profile') }}</x-primary-button>
                    @else
                        <h1>Profile Information</h1>
                        <h3 class="mt-3"><strong>Company Name: </strong>{{ $profile->companyName }}</h3>
                        <h3 class="mt-3"><strong>Company Address: </strong>{{ $profile->companyAddress }}</h3>
                        <h3 class="mt-3"><strong>Company Head: </strong>{{ $profile->companyHead }}</h3>
                        <h3 class="mt-3"><strong>Company Head Title: </strong>{{ $profile->companyHeadTitle }}</h3>
                        <h3 class="mt-3"><strong>Company Type: </strong>{{ $profile->companyType }}</h3>
                        <h3 class="mt-3"><strong>Company Description: </strong>{{ $profile->companyDescription }}</h3>

                        <a href="{{ route('admin.company_profile.edit', ['company_profile' => $profile->id]) }}">
                            <x-primary-button class="mt-4">{{ __('Edit') }}</x-primary-button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-company-profile" focusable>
        <form method="post" action="{{ route('admin.company_profile.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add Company Profile') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Please enter the following informations needed for your company profile.') }}
            </p>

            <div class="mt-6">
                <div>
                    <x-input-label for="companyName" :value="__('Company Name')" />
                    <x-text-input id="companyName" class="block mt-1 w-full" type="text" name="companyName"
                        :value="old('companyName')" required autofocus autocomplete="companyName" />
                    <x-input-error :messages="$errors->get('companyName')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="companyAddress" :value="__('Company Address')" />
                    <x-text-input id="companyAddress" class="block mt-1 w-full" type="text" name="companyAddress"
                        :value="old('companyAddress')" required autofocus autocomplete="companyAddress" />
                    <x-input-error :messages="$errors->get('companyAddress')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="companyHead" :value="__('Company Head')" />
                    <x-text-input id="companyHead" class="block mt-1 w-full" type="text" name="companyHead"
                        :value="old('companyHead')" required autofocus autocomplete="companyHead" />
                    <x-input-error :messages="$errors->get('companyHead')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="companyHeadTitle" :value="__('Company Head Title')" />
                    <x-text-input id="companyHeadTitle" class="block mt-1 w-full" type="text" name="companyHeadTitle"
                        :value="old('companyHeadTitle')" required autofocus autocomplete="companyHeadTitle" />
                    <x-input-error :messages="$errors->get('companyHeadTitle')" class="mt-2" />
                </div class="mt-4">

                <div class="mt-4">
                    <x-input-label for="companyType" :value="__('Company Type')" />
                    <x-text-input id="companyType" class="block mt-1 w-full" type="text" name="companyType"
                        :value="old('companyType')" required autofocus autocomplete="companyType" />
                    <x-input-error :messages="$errors->get('companyType')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="companyDescription" :value="__('Company Description')" />
                    <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                        name="companyDescription" id="companyDescription" rows=4" required autofocus autocomplete="companyDescription">
                    {{ old('companyDescription') }}
                    </textarea>
                    <x-input-error :messages="$errors->get('companyDescription')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>
