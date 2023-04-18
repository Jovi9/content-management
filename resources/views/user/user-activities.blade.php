@extends('layouts.app')
@section('title', 'User Activity')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/data-table/datatables.min.css') }}">
@endsection

@section('page-header', 'User Activities')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-responsive-sm" id="tableUserActivities">
                            <thead>
                                <tr>
                                    <th scope="col">User</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        @php
                                            foreach ($users as $user) {
                                                if ($user->id == $log->user_id) {
                                                    $nameOfUser = $user->firstName . ' ' . $user->lastName;
                                                }
                                            }
                                        @endphp
                                        <td>{{ $nameOfUser }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ date('M-d-Y h:i A', strtotime($log->created_at)) }}</td>
                                        <td><button class="btn btn-secondary" id="btnViewActivity"
                                                data-id="{{ Crypt::encrypt($log->id) }}" data-toggle="modal"
                                                data-target="#modalViewLog">View</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="modalViewLog" tabindex="-1" role="dialog" aria-labelledby="modalViewLog"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewLog"><strong>Log Details</strong></h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">User</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="user"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Action</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="action"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Content</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="content"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Changes</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="changes"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Date</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="date"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" id="btnClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/data-table/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var X_CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

            $('#tableUserActivities').DataTable();

            $(document).on('click', '#btnViewActivity', function() {
                var log_id = $(this).data('id');


                $.ajax({
                    type: "POST",
                    url: "{{ route('user-activity-get') }}",
                    data: {
                        _token: X_CSRF_TOKEN,
                        id: log_id,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $('#user').text(response.user);
                        $('#action').text(response.action);
                        $('#content').text(response.content);
                        $('#changes').text(response.changes);
                        $('#date').text(response.date);
                    }
                });
            });

            $('#btnClose').click(function(e) {
                $('#user').text("");
                $('#action').text("");
                $('#content').text("");
                $('#changes').text("");
                $('#date').text("");
            });
        });
    </script>
@endsection
