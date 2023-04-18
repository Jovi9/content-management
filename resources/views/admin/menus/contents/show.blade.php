@extends('layouts.app')
@section('title', $menuName)

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Contents of ' . $menuName)
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            @if ($subURI === 'none')
                                <a href="{{ route('admin.contents-create', ['main' => $mainURI]) }}"
                                    class="btn btn-primary"><i class="fa fa-plus"></i> Add New Content</a>
                            @else
                                <a href="{{ route('admin.contents-create', ['main' => $mainURI . '/' . $subURI]) }}"
                                    class="btn btn-primary"><i class="fa fa-plus"></i> Add New Content</a>
                            @endif
                        </div>
                        <table class="table table-responsive-sm" id="">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Date Updated</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($contents)
                                    @foreach ($contents as $content)
                                        <tr>
                                            <td>{{ ucwords($content['title']) }}</td>
                                            <td>{{ $content['created_at'] }}</td>
                                            <td>{{ $content['updated_at'] }}</td>
                                            <td>{{ ucwords($content['status']) }}</td>
                                            <td>{{ ucwords($content['created_by']->firstName . ' ' . $content['created_by']->lastName) }}
                                            </td>
                                            <td>{{ ucwords($content['updated_by']->firstName . ' ' . $content['updated_by']->lastName) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.contents-edit', ['id' => $content['id']]) }}"
                                                    class="btn btn-primary"><i class="fa fa-edit"></i></a>
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
@endsection

@section('scripts')
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
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
