<x-app-layout>
    @section('title', 'Departments')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Departments</h1>
                    <a href="{{ route('admin.departments.create') }}">
                        <x-primary-button class="mt-2">{{ __('Add New Department') }}</x-primary-button>
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
                                    Department</th>
                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                            @foreach ($departments as $department)
                                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                            class="inline-block w-1/3 md:hidden font-bold">Department
                                        </span>{{ Str::ucfirst($department->departmentName) }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>
                                        <a
                                            href="{{ route('admin.departments.edit', ['department' => Crypt::encrypt($department->id)]) }}">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Edit</button></a>
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

    @if (Session::has('saved'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'New Department Saved Successfully.',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif

    @if (Session::has('updated'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Department Updated Successfully.',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif
</x-app-layout>
