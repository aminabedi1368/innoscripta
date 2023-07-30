@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="payment_id">User Id</label>
                        <input type="text" disabled class="form-control" id="payment_id" value="{{ $user->id }}">
                    </div>

                    <div class="form-group">
                        <label for="amount">First Name</label>
                        <input type="text" disabled class="form-control" id="amount" value="{{ $user->first_name }}">
                    </div>

                    <div class="form-group">
                        <label for="user_id">Last Name</label>
                        <input type="text" disabled class="form-control" id="user_id" value="{{ $user->last_name }}">
                    </div>

                    <div class="form-group">
                        <label for="order_id">Status</label>
                        <input type="text" disabled class="form-control" id="order_id" value="{{ $user->status }}">
                    </div>

                </div>
        </div>
    </div>
    </div>

    @if(session('success_message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            {{ session('success_message') }}
        </div>
    @endif

        @if(array_key_exists('username', $user->app_fields) && $user->app_fields['username'] === "root")

        @else
            <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List User Identifiers</h3>

                    <a class="btn btn-success float-right" href="{{ route('admin.user_identifier.create_form', ['user_id' => $user->id] ) }}">Add New Identifier</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                            Index
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Identifier Type
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Identifier Value
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Created At
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Is Verified
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($user->userIdentifiers as $userIdentifier)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ $loop->index+1 }}</td>
                                            <td class="sorting_1">{{ $userIdentifier->type }}</td>
                                            <td class="sorting_1">{{ $userIdentifier->value }}</td>
                                            <td class="sorting_1">{{ $userIdentifier->created_at }}</td>
                                            <td class="sorting_1">
                                                {{ $userIdentifier->is_verified ? "YES" : "NO" }}
                                            </td>
                                            <td class="sorting_1">
                                                <a class="btn btn-warning" href="{{ route('admin.user_identifier.edit_user_identifier_form', ['user_identifier_id' => $userIdentifier->id]) }}">Edit</a>
                                                <a class="btn btn-danger" href="{{ route('admin.user_identifier.delete_user_identifier', ['id' => $userIdentifier->id]) }}">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Index</th>
                                        <th rowspan="1" colspan="1">Identifier Type</th>
                                        <th rowspan="1" colspan="1">Identifier Value</th>
                                        <th rowspan="1" colspan="1">Created At</th>
                                        <th rowspan="1" colspan="1">Is Verified</th>
                                        <th rowspan="1" colspan="1">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
        @endif
@stop
@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop
