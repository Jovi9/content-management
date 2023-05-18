@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

<div>
    @section('title', 'Featured')
    @section('page-header', 'Featured')

    <div class="row">
        <div class="col-md-6">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-responsive-sm" id="">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($contents)
                                    @foreach ($contents as $content)
                                        <tr>
                                            <td>{{ $content->title }}</td>
                                            <td>
                                                @if ($content->isVisibleHome === 0)
                                                    {{ __('Hidden') }}
                                                @else
                                                    {{ __('Visible') }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $content->id }}"
                                                        @if ($content->isVisibleHome === 1) checked @endif
                                                        wire:click="toggleVisibilityStatus('{{ $content->id }}')">
                                                    {{-- <label class="form-check-label" for="{{ $content->id }}">

                                                    </label> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @livewireScripts
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        window.addEventListener('swal-modal', event => {
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: event.detail.title,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endsection
