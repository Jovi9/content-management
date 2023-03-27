<div>
    <div class=" flex justify-between">
        <div>
            <h1 class=" lg:text-2xl"><strong>Contents Menu</strong></h1>
        </div>
    </div>
    <table class="min-w-full border-collapse block md:table mt-4">
        <thead class="block md:table-header-group">
            <tr
                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Menu Name</th>
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Location</th>
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Action</th>
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Status</th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            @foreach ($menus as $menu)
                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Menu Name
                        </span>
                        {{ $menu['main_menu'] }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Location</span>
                        {{ $menu['location'] }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Action</span>

                        @if ($menu['sub_menu'] == 'none')
                            @if (!($menu['main_menu'] == 'Home' || $menu['main_menu'] == 'About' || $menu['main_menu'] == 'Contact Us'))
                                <a href="{{ route('user.show-content-main', ['menu' => $menu['main_menu']]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                    <i class="fa fa-eye"></i>
                                    Contents
                                </a>
                            @endif
                        @else
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded"
                                wire:click="showSubMenus({{ $menu['id'] }})" wire:loading.remove
                                x-data="" x-on:click.prevent="$dispatch('open-modal', 'show-sub-menu')">
                                <i class="fa fa-eye"></i>
                                Sub Menu
                            </button>
                        @endif

                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Status</span>
                        {{ ucwords($menu['status']) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- show sub menu --}}
    <x-modal-v1 name="show-sub-menu" focusable maxWidth="lg">
        {{-- title --}}
        <div class="bg-gray-300 p-4">
            <h1 class=" text-xl font-medium ">
                @if ($mainMenu)
                    {{ $mainMenu->main_menu . __(' Sub Menu') }}
                @endif
            </h1>
        </div>

        {{-- body --}}
        <div class="bg-white p-5">
            <table class="min-w-full border-collapse block md:table mt-4">
                <thead class="block md:table-header-group">
                    <tr
                        class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                        <th
                            class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                            Sub Menu</th>
                        <th
                            class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                            Location</th>
                        <th
                            class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                            Action</th>
                        <th
                            class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="block md:table-row-group">
                    @foreach ($subMenus as $subMenu)
                        <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Sub Menu
                                </span>
                                {{ $subMenu->sub_menu }}
                            </td>
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Location</span>
                                {{ $subMenu->sub_location }}
                            </td>
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Action</span>
                                @if (!($subMenu->sub_menu == 'None'))
                                    <a href="{{ route('user.show-content-sub', ['menu' => $mainMenu->main_menu, 'sub_menu' => $subMenu->sub_menu]) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                        <i class="fa fa-eye"></i>
                                        Contents
                                    </a>
                                @endif
                            </td>
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Status</span>
                                @if (!($subMenu->sub_menu == 'None'))
                                    {{ ucwords($subMenu->sub_status) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- footer --}}
        <div class="bg-gray-300 p-4">
            <div class="flex justify-end space-x-2">
                <button type="button" x-on:click="$dispatch('close-modal', 'show-sub-menu')" wire:click="resetForm()"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Close
                </button>
            </div>
        </div>
    </x-modal-v1>
</div>
