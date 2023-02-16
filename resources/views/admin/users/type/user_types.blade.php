<x-app-layout>
    @section('title', 'Users Type')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Users Type</h1>
                    <a href="{{ route('admin.user_types.create') }}">
                        <x-primary-button class="mt-2">{{ __('Add New User Type') }}</x-primary-button>
                    </a>
                    <a href="{{ route('admin.users.index') }}">
                        <x-primary-button>{{ __('Users') }}</x-primary-button>
                    </a>
                    <!-- component -->
                    <table class="min-w-full border-collapse block md:table mt-4">
                        <thead class="block md:table-header-group">
                            <tr
                                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    User Type</th>
                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                            @foreach ($userTypes as $userType)
                                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                            class="inline-block w-1/3 md:hidden font-bold">User
                                            Type</span>{{ Str::ucfirst($userType->userTypeName) }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>
                                        @if (!($userType->userTypeName == 'administrator'))
                                            <a
                                                href="{{ route('admin.user_types.edit', ['user_type' => $userType->id]) }}">
                                                <button
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Edit</button></a>
                                        @endif
                                        {{-- <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">Delete</button> --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
