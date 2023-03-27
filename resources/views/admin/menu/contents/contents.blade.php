<x-app-layout>
    @section('title', 'Contents')
    @section('styles')
        @livewireStyles
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contents') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" text-gray-900">
                    <div class=" grid lg:grid-cols-2 gap-8 sm:grid-cols-1">
                        <div class=" p-6 bg-white rounded">
                            @livewire('content.content-menu')
                        </div>
                        {{-- <div class=" p-6 bg-white rounded">
                            @livewire('menu.sub-menu')
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        @livewireScripts
    @endsection
</x-app-layout>
