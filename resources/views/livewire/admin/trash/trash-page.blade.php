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
                    if (event.detail.args === 'menu-trash') {
                        Livewire.emit('permanentDeleteSelected');
                    } else if (event.detail.args === 'site-banner') {
                        Livewire.emit('permanentDeleteBanner');
                    } else if (event.detail.args === 'news-trash') {
                        Livewire.emit('permanentDeleteNews');
                    } else {
                        //  
                    }
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
                @livewire('admin.trash.menu-trash')
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <div class="accordion" id="accordionSiteBanner">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSiteBanner">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSiteBanner" aria-expanded="false"
                                aria-controls="collapseSiteBanner">
                                Site Banners
                            </button>
                        </h2>
                        <div id="collapseSiteBanner" class="accordion-collapse collapse"
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
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNews" aria-expanded="false" aria-controls="collapseNews">
                                News
                            </button>
                        </h2>
                        <div id="collapseNews" class="accordion-collapse collapse" aria-labelledby="headingNews"
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
