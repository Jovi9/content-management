<x-guest-layout>
    @section('title', ucwords($menuName))
    @section('styles')
        {{-- <style>
            ul {
                list-style-type: disc;
            }
        </style> --}}
    @endsection
    @include('layouts.guest_navigation')

    {{-- header --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $menuName }}
            </h2>
        </div>
    </header>

    @foreach ($contents as $content)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __('Title: ') . $content->title }}
                        <div class="mt-4">
                            {!! $content->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    {{-- @section('scripts')
        <script>
            $(document).ready(function() {
                $('ul').addClass('list-disc');
                $('ol').addClass('list-decimal');
            });
        </script>
    @endsection --}}
</x-guest-layout>
