<x-app-layout>
    @if (isset($is_SubMenu))
        @section('title', ucwords($is_SubMenu) . ' Contents')
    @else
        @section('title', ucwords($menu->main_menu) . ' Contents')
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($is_SubMenu))
                {{ ucwords($is_SubMenu) . __(' Contents') }}
            @else
                {{ ucwords($menu->main_menu) . __(' Contents') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" text-gray-900 p-6 bg-white">
                    {{-- @livewire('content.show-contents', ['menuID' => $menu->id, 'subID' => $subMenu]) --}}
                    <div class=" flex justify-between">
                        <div>
                            <h1 class=" lg:text-2xl"><strong>Contents</strong></h1>
                        </div>
                        @if (isset($is_SubMenu))
                            <a class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                href="{{ route('user.create-sub-content', ['menu' => $menu->main_menu, 'sub_menu' => $is_SubMenu]) }}">Add
                                New</a>
                        @else
                            <a class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                href="{{ route('user.create-content', ['menu' => $menu->main_menu]) }}">Add
                                New</a>
                        @endif
                    </div>
                    <table class="min-w-full border-collapse block md:table mt-4">
                        <thead class="block md:table-header-group">
                            <tr
                                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Title</th>

                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Created</th>

                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Last Updated</th>

                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Status</th>

                                <th
                                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                            @foreach ($contents as $content)
                                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Sub Menu
                                        </span>
                                        {{ $content->title }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Main Menu
                                        </span>
                                        {!! $content->created_at !!}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Main Menu
                                        </span>
                                        {!! $content->updated_at !!}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Status</span>
                                        {{ ucwords($content->status) }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Action</span>
                                        @if (isset($is_SubMenu))
                                            <a
                                                href="{{ route('user.edit-sub-content', ['menu' => $menu->main_menu, 'sub_menu' => $is_SubMenu, 'id' => Crypt::encrypt($content->id)]) }}">
                                                <button
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                        @else
                                            <a
                                                href="{{ route('user.edit-content', ['menu' => $menu->main_menu, 'id' => Crypt::encrypt($content->id)]) }}">
                                                <button
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                        @endif
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
                title: 'New Content Saved Successfully.',
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
                title: 'Content Updated Successfully.',
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
