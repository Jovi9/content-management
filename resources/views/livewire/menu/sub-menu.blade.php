<div>
    <div class=" flex justify-between">
        <div>
            <h1 class=" lg:text-2xl"><strong>Sub Menu</strong></h1>
        </div>
        <div x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-sub-menu')"
            wire:loading.attr="disabled"
            class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <button class="">Add New</button>
        </div>
    </div>
    <table class="min-w-full border-collapse block md:table mt-4">
        <thead class="block md:table-header-group">
            <tr
                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Sub Menu</th>

                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Main Menu</th>
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
                        <span class="inline-block w-1/3 md:hidden font-bold">Main Menu
                        </span>
                        {{ $subMenu->main_menu }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Location</span>
                        {{ $subMenu->sub_location }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Action</span>
                        @if (!($subMenu->sub_menu == 'None'))
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded"
                                wire:click="editMenu({{ $subMenu->id }})" wire:loading.attr="disabled"
                                x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-sub-menu')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Status</span>
                        @if (!($subMenu->sub_menu == 'None'))
                            <input
                                class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-neutral-300 dark:bg-neutral-600 before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-neutral-100 dark:after:bg-neutral-400 after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary dark:checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary dark:checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                type="checkbox" role="switch" id="switchStatus"
                                wire:click="switchStatus({{ $subMenu->id }})"
                                @if ($subMenu->sub_status == 'enabled') checked @endif />
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- add modal --}}
    <x-modal-v1 name="add-sub-menu" focusable maxWidth="md">
        <form action="javascript:void(0);" wire:submit.prevent="store" novalidate>
            @csrf
            {{-- title --}}
            <div class="bg-gray-300 p-4">
                <h1 class=" text-xl font-medium ">
                    Add Sub Menu
                </h1>
            </div>

            {{-- body --}}
            <div class="bg-white p-5">
                <div>
                    <label class="block font-medium text-sm text-gray-700">
                        Main Menu
                    </label>
                    <select wire:model="mainMenuID">
                        <option value="">Choose main menu</option>
                        @foreach ($mainMenus as $mainMenu)
                            <option value="{{ $mainMenu->id }}">
                                {{ $mainMenu->main_menu }}
                            </option>
                        @endforeach
                    </select>
                    @error('mainMenuID')
                        <span class="error text-red-600">{{ __('Please select main menu.') }}</span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">
                        Sub Menu Name
                    </label>
                    <input type="text" wire:model.lazy="subMenu"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                        required>
                    @error('subMenu')
                        <span class="error text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- footer --}}
            <div class="bg-gray-300 p-4">
                <div class="flex justify-end space-x-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'add-sub-menu')"
                        wire:click="resetForm()"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </button>
                    <button type="submit" wire:loading.remove
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </x-modal-v1>

    {{-- edit modal --}}
    <x-modal-v1 name="edit-sub-menu" focusable maxWidth="md">
        <form action="javascript:void(0);" wire:submit.prevent="update" novalidate>
            @csrf
            {{-- title --}}
            <div class="bg-gray-300 p-4">
                <h1 class=" text-xl font-medium ">
                    Edit Sub Menu
                </h1>
            </div>

            {{-- body --}}
            <div class="bg-white p-5">
                <div>
                    <label class="block font-medium text-sm text-gray-700">
                        Main Menu
                    </label>
                    <select wire:model="mainMenuID">
                        <option value="">Choose main menu</option>
                        @foreach ($mainMenus as $mainMenu)
                            <option value="{{ $mainMenu->id }}" @if ($mainMenu->id == $mainMenuID) selected @endif>
                                {{ $mainMenu->main_menu }}
                            </option>
                        @endforeach
                    </select>
                    @error('mainMenuID')
                        <span class="error text-red-600">{{ __('Please select main menu.') }}</span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">
                        Sub Menu Name
                    </label>
                    <input type="text" wire:model.lazy="subMenu"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                        required>
                    @error('subMenu')
                        <span class="error text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- footer --}}
            <div class="bg-gray-300 p-4">
                <div class="flex justify-end space-x-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-sub-menu')"
                        wire:click="resetForm()"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </button>
                    <button type="submit" wire:loading.remove
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </x-modal-v1>
</div>
