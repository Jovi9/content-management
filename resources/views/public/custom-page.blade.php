@extends('layouts.guest')

@section('title', $menuName)

@section('content')
    @if ($contents)
        <div class="py-5">
            @foreach ($contents as $content)
                <div class="container-fluid mb-4">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ $content->title }}</div>
                                <div class="card-body">
                                    {!! $content->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('assets/jquery/jquery-3.6.3.min.js') }}"></script>
    <script>
        $('img').addClass('img-fluid');
    </script>
@endsection
