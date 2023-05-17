@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .accordion-button {
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
@endsection
@section('scripts')
    @livewireScripts
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        window.addEventListener('restore-selected', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: event.detail.title,
            });
        });

        window.addEventListener('permanent-delete', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('permanentDeleteSelected');
                }
            })
        });

        window.addEventListener('deleted-permanently', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: event.detail.title,
            });
        });
    </script>
@endsection
<div>
    @section('title', 'Trash')
    @section('page-header', 'Trash')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion mb-5" id="trashAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingMainMenu">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseMainMenu" aria-expanded="true"
                                aria-controls="collapseMainMenu">
                                Main Menus
                            </button>
                        </h2>
                        <div id="collapseMainMenu" class="accordion-collapse collapse show"
                            aria-labelledby="headingMainMenu" data-bs-parent="#trashAccordion">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Main Menu</th>
                                            <th scope="col">Date Deleted</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($mainMenus)
                                            @foreach ($mainMenus as $mainMenu)
                                                <tr>
                                                    <th scope="row">{{ $mainMenu['mainMenu'] }}</th>
                                                    <td>{{ $mainMenu['deleted_at'] }}</td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                            wire:click="restoreSelectedMainMenu('{{ $mainMenu['id'] }}')">Restore</button>
                                                        <button class="btn btn-danger"
                                                            wire:click="deleteSelectedMainMenu('{{ $mainMenu['id'] }}')">Permanent
                                                            Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSubMenu">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSubMenu" aria-expanded="false" aria-controls="collapseSubMenu">
                                Sub Menus
                            </button>
                        </h2>
                        <div id="collapseSubMenu" class="accordion-collapse collapse show"
                            aria-labelledby="headingSubMenu" data-bs-parent="#trashAccordion">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Main Menu</th>
                                            <th scope="col">Sub Menu</th>
                                            <th scope="col">Date Deleted</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($subMenus)
                                            @foreach ($subMenus as $subMenu)
                                                <tr>
                                                    <th scope="row">{{ $subMenu['mainMenu'] }}</th>
                                                    <th scope="row">{{ $subMenu['subMenu'] }}</th>
                                                    <td>{{ $subMenu['deleted_at'] }}</td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                            wire:click="restoreSelectedSubMenu('{{ $subMenu['id'] }}')">Restore</button>
                                                        <button class="btn btn-danger"
                                                            wire:click="deleteSelectedSubMenu('{{ $subMenu['id'] }}')">Permanent
                                                            Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingContent">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseContent" aria-expanded="false" aria-controls="collapseContent">
                                Contents
                            </button>
                        </h2>
                        <div id="collapseContent" class="accordion-collapse collapse show"
                            aria-labelledby="headingContent" data-bs-parent="#trashAccordion">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Main Menu</th>
                                            <th scope="col">Sub Menu</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Date Deleted</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($contents)
                                            @foreach ($contents as $content)
                                                <tr>
                                                    <th scope="row">{{ $content['mainMenu'] }}</th>
                                                    <th scope="row">{{ $content['subMenu'] }}</th>
                                                    <th scope="row">{{ $content['title'] }}</th>
                                                    <td>{{ $content['deleted_at'] }}</td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                            wire:click="restoreSelectedContent('{{ $content['id'] }}')">Restore</button>
                                                        <button class="btn btn-danger"
                                                            wire:click="deleteSelectedContent('{{ $content['id'] }}')">Permanent
                                                            Delete</button>
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

        <div class="row mb-5">
            <div class="col-md-12">
                <div class="accordion" id="accordionSiteBanner">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSiteBanner">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSiteBanner" aria-expanded="true"
                                aria-controls="collapseSiteBanner">
                                Site Banners
                            </button>
                        </h2>
                        <div id="collapseSiteBanner" class="accordion-collapse collapse show"
                            aria-labelledby="headingSiteBanner" data-bs-parent="#accordionSiteBanner">
                            <div class="accordion-body">
                                @livewire('admin.trash.site-banner-trash')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="accordion" id="accordionNews">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNews">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNews" aria-expanded="true" aria-controls="collapseNews">
                                News
                            </button>
                        </h2>
                        <div id="collapseNews" class="accordion-collapse collapse show" aria-labelledby="headingNews"
                            data-bs-parent="#accordionNews">
                            <div class="accordion-body">
                                @livewire('admin.trash.news-trash-page')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
