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

                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @role('administrator')
        <div class=" pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" text-gray-900">
                        <div class=" p-6 bg-white rounded">
                            @livewire('content.manage-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @section('scripts')
        @livewireScripts
        <script>
            window.addEventListener('swal-modal', event => {
                if (event.detail.title == "error") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to process request.',
                        text: 'Something went wrong, please try again.',
                        allowOutsideClick: false
                    });
                } else if (event.detail.title == "saved") {
                    Swal.fire({
                        icon: 'success',
                        title: event.detail.message,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                }
            });
        </script>
    @endsection
</x-app-layout>
