@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success_message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    {{ session('success_message') }}
                </div>
            @endif


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List Users</h3>
                    <a class="btn btn-success float-right" href="{{ route('admin.user.create_form') }}">Create User</a>
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
                                            ID
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            First Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Last Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Avatar
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Created At
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Is Super Admin
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($users as $user)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ $user->id }}</td>
                                            <td class="sorting_1">{{ $user->first_name }}</td>
                                            <td class="sorting_1">{{ $user->last_name }}</td>
                                            <td class="sorting_1">
                                                @if($user->avatar)
                                                    <img width="90px" height="90px;" src="{{\Illuminate\Support\Facades\Storage::url($user->avatar)}}" />
                                                @else
                                                    <img width="90px" height="90px;" src="/storage/avatar/avatar_user.png" />
                                                @endif
                                            </td>
                                            <td class="sorting_1">{{ $user->created_at }}</td>
                                            <td class="sorting_1">
                                                {{ $user->is_super_admin ? "YES" : "NO" }}
                                            </td>
                                            <td class="sorting_1">
                                                <a class="btn btn-info" href="{{ route('admin.token.list_user_tokens', ['user_id' => $user->id]) }}">Sessions</a>
                                                <a class="btn btn-primary" href="{{ route('admin.user.show_user', ['id' => $user->id]) }}">View</a>

                                                @if(array_key_exists('username', $user->app_fields) && $user->app_fields['username'] === "root")
                                                    <a style="pointer-events: auto;" title="You cant edit superuser" class="btn btn-warning disabled" href="{{ route('admin.user.edit_form', ['id' => $user->id]) }}">Edit</a>
                                                    <a style="pointer-events: auto;" title="You cant delete superuser" class="btn btn-danger disabled" href="{{ route('admin.user.delete_user', ['id' => $user->id]) }}">Remove</a>
                                                    <a class="btn btn-info disabled" disabled href="">Roles</a>
                                                @else
                                                    <a class="btn btn-warning" href="{{ route('admin.user.edit_form', ['id' => $user->id]) }}">Edit</a>
                                                    <a class="btn btn-danger" href="{{ route('admin.user.delete_user', ['id' => $user->id]) }}">Remove</a>
                                                    <a class="btn btn-info" href="{{ route('admin.user.list_user_roles', ['id' => $user->id]) }}">Roles</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">ID</th>
                                        <th rowspan="1" colspan="1">First Name</th>
                                        <th rowspan="1" colspan="1">Last Name</th>
                                        <th rowspan="1" colspan="1">Avatar</th>
                                        <th rowspan="1" colspan="1">Created At</th>
                                        <th rowspan="1" colspan="1">Is Super Admin</th>
                                        <th rowspan="1" colspan="1">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            {{ $users->links() }}
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
