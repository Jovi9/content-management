@extends('layouts.guest')

@section('title', $menuName)

@section('content')

    @if (!$contents->isEmpty())
        @if ($contents)
            @foreach ($contents as $content)
                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="bg-white">
                                    <div class="container px-4 py-4">
                                        <h2 class="pb-2 border-bottom border-4">{{ $content->title }}</h2>
                                        <div class="row mt-4">
                                            {!! $content->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @else
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                {{-- <h1 class="display-1 fw-bold">404</h1> --}}
                <p class="fs-3"> <span class="text-danger">Opps!</span> Empty Page.</p>
                <p class="lead">
                    The page you’re looking for currently have no content.
                </p>
                <a href="{{ route('public-home') }}" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $('img').addClass('img-fluid');
    </script>
@endsection
