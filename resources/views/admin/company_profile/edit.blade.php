<x-app-layout>
    @section('title', 'Edit Company Profile')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post"
                        action="{{ route('admin.company_profile.update', ['company_profile' => Crypt::encrypt($profile->id)]) }}"
                        class="p-6">
                        @csrf
                        @method('put')

                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Edit Company Profile') }}
                        </h2>

                        <div class="mt-6">
                            <div>
                                <x-input-label for="companyName" :value="__('Company Name')" />
                                <x-text-input id="companyName" class="block mt-1 w-full" type="text"
                                    name="companyName" value="{{ $profile->companyName }}" required autofocus
                                    autocomplete="companyName" />
                                <x-input-error :messages="$errors->get('companyName')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="companyAddress" :value="__('Company Address')" />
                                <x-text-input id="companyAddress" class="block mt-1 w-full" type="text"
                                    name="companyAddress" value="{{ $profile->companyAddress }}" required autofocus
                                    autocomplete="companyAddress" />
                                <x-input-error :messages="$errors->get('companyAddress')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="companyHead" :value="__('Company Head')" />
                                <x-text-input id="companyHead" class="block mt-1 w-full" type="text"
                                    name="companyHead" value="{{ $profile->companyHead }}" required autofocus
                                    autocomplete="companyHead" />
                                <x-input-error :messages="$errors->get('companyHead')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="companyHeadTitle" :value="__('Company Head Title')" />
                                <x-text-input id="companyHeadTitle" class="block mt-1 w-full" type="text"
                                    name="companyHeadTitle" value="{{ $profile->companyHeadTitle }}" required autofocus
                                    autocomplete="companyHeadTitle" />
                                <x-input-error :messages="$errors->get('companyHeadTitle')" class="mt-2" />
                            </div class="mt-4">

                            <div class="mt-4">
                                <x-input-label for="companyType" :value="__('Company Type')" />
                                <x-text-input id="companyType" class="block mt-1 w-full" type="text"
                                    name="companyType" value="{{ $profile->companyType }}" required autofocus
                                    autocomplete="companyType" />
                                <x-input-error :messages="$errors->get('companyType')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="companyDescription" :value="__('Company Description')" />
                                <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                                    name="companyDescription" id="companyDescription" rows="4" required autofocus
                                    autocomplete="companyDescription">
                                {{ $profile->companyDescription }}
                                </textarea>
                                <x-input-error :messages="$errors->get('companyDescription')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.company_profile.index') }}">
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
