<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <div class="flex space-x-7">
                <div>
                    <!-- Website Logo -->
                    <a href="#" class="flex items-center py-4 px-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <!-- Primary Navbar items -->
                <div class="hidden md:flex items-center space-x-1">
                    @if ($mainMenus)
                        @foreach ($mainMenus as $mainMenu)
                            @if ($mainMenu['sub_menu'] == 'none')
                                <a href="{{ route('public-main_con-show', $mainMenu['main_menu']) }}"
                                    class="py-4 px-2 text-gray-500 font-medium border-b-2 border-transparent text-sm leading- hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    {{ $mainMenu['main_menu'] }}
                                </a>
                            @else
                                <div class="hidden sm:flex sm:items-center sm:ml-6">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <div>{{ $mainMenu['main_menu'] }}</div>

                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            @foreach ($mainMenu['sub_menu'] as $subMenu)
                                                <x-dropdown-link
                                                    href="{{ route('public-sub_con-show', ['menu' => $mainMenu['main_menu'], 'sub_menu' => $subMenu->sub_menu]) }}">
                                                    {{ $subMenu->sub_menu }}
                                                </x-dropdown-link>
                                            @endforeach
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
            <!-- Secondary Navbar items -->
            <div class="hidden md:flex items-center space-x-3 ">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="py-4 px-2 text-gray-500 font-medium border-b-2 border-transparent text-sm leading- hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Log In') }}
                        </a>
                    @endauth
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button class="outline-none mobile-menu-button">
                    <svg class=" w-6 h-6 text-gray-500 hover:text-green-500 " x-show="!showMenu" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- mobile menu -->
    <div class="hidden mobile-menu">
        <ul class="">
            @if ($mainMenus)
                @foreach ($mainMenus as $mainMenu)
                    @if ($mainMenu['sub_menu'] == 'none')
                        <li class="">
                            <a href="{{ route('public-main_con-show', $mainMenu['main_menu']) }}"
                                class="block text-sm px-2 py-4 text-gray-500 font-semibold">
                                {{ $mainMenu['main_menu'] }}
                            </a>
                        </li>
                    @else
                        <li>
                            <div @click.away="open = false" class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-simeb text-gray-500 old text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                    <span>
                                        {{ $mainMenu['main_menu'] }}
                                    </span>
                                    <svg fill="currentColor" viewBox="0 0 20 20"
                                        :class="{ 'rotate-180': open, 'rotate-0': !open }"
                                        class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
                                    <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                                        @foreach ($mainMenu['sub_menu'] as $subMenu)
                                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                href="{{ route('public-sub_con-show', ['menu' => $mainMenu['main_menu'], 'sub_menu' => $subMenu->sub_menu]) }}">
                                                {{ $subMenu->sub_menu }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
    <script>
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</nav>
