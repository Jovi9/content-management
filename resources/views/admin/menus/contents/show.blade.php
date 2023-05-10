@extends('layouts.app')
@section('title', $menuName)

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    @livewireStyles
@endsection

@section('page-header', 'Contents of ' . $menuName)
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        @livewire('admin.menus.contents.show-contents', ['mainMenuID' => $mainMenuID, 'subMenuID' => $subMenuID])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @livewireScripts
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        window.addEventListener('close-modal', event => {
            $(event.detail.modal_id).modal('hide');
        });

        window.addEventListener('reload-page', event => {
            location.reload();
        });

        window.addEventListener('swal-modal', event => {
            if (event.detail.title == "saved") {
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
            } else if (event.detail.title == "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to process request.',
                    text: 'Something went wrong, please try again.',
                    allowOutsideClick: false
                });
            } else if (event.detail.title == "empty") {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to process request.',
                    text: event.detail.message,
                    allowOutsideClick: false
                });
            }
        });

        window.addEventListener('delete-selected', event => {
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
                    Livewire.emit('deleteContent');
                }
            })
        });
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.move-up, .move-down', function() {
                var row = $(this).parents("tr:first");
                if ($(this).is(".move-up")) {
                    row.insertBefore(row.prev());
                } else {
                    row.insertAfter(row.next());
                }
            });

            $(document).on('click', '#btnSave', function() {
                var tableData = $('#tableSource input[type="text"]').serializeArray();
                Livewire.emit('updateArrangement', tableData);
            });
        });
    </script>

    @if (Session::has('saved'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'New Content Saved Successfully.',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif
    @if (Session::has('updated'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Content Updated Successfully.',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif
@endsection
