@extends('adminlte::page')

@section('title', 'Bad Logins')

@section('content_header')
    <h1>Bad Logins</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bad Logins</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div></div><div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                            Index
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Username
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Password
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Loin Type
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Device Type
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Device OS
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Created At
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($bad_logins as $bad_login)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ ($loop->index + 1) }}</td>
                                            <td class="sorting_1">{{ $bad_login->username }}</td>
                                            <td class="sorting_1">{{ $bad_login->password }}</td>
                                            <td class="sorting_1">{{ $bad_login->login_type }}</td>
                                            <td class="sorting_1">{{ $bad_login->device_type }}</td>
                                            <td class="sorting_1">{{ $bad_login->device_os }}</td>
                                            <td class="sorting_1">{{ $bad_login->created_at }}</td>
                                            <td class="sorting_1">
                                                <a class="btn btn-info" href="#">Details</a>

                                                @if($bad_login->user_identifier_id)
                                                    <a class="btn btn-warning" href="{{ route('admin.user.show_user', ['id' => $bad_login->userIdentifier->user_id]) }}">User</a>
                                                @else
                                                    <a class="btn btn-dark" href="#">User</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Index</th>
                                        <th rowspan="1" colspan="1">Username</th>
                                        <th rowspan="1" colspan="1">Password</th>
                                        <th rowspan="1" colspan="1">Login Type</th>
                                        <th rowspan="1" colspan="1">Device Type</th>
                                        <th rowspan="1" colspan="1">Device OS</th>
                                        <th rowspan="1" colspan="1">Created At</th>
                                        <th rowspan="1" colspan="1">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            {{ $bad_logins->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
