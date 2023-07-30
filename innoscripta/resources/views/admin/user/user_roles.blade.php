@extends('adminlte::page')

@section('title', 'User Roles')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input disabled name="first_name" type="text" class="form-control disabled" id="first_name" value="{{ $user->first_name }}">
                    </div>


                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" type="text" class="form-control disabled" disabled id="last_name" value="{{ $user->last_name }}">
                    </div>
                </div>

                <!-- /.card-body -->
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Role</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <form action="{{ route('admin.user.add_role_to_user') }}" method="POST">

                        @csrf
                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <select id="project_id" name="project_id" class="form-control">
                                <option  value="select_one_please" selected="selected" disabled="disabled">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role_id">Roles</label>
                            <select id="role_id" name="role_id" class="form-control">
                                <option>Please Select a Project</option>
                            </select>
                        </div>

                        <input name="user_id" type="hidden" value="{{$user->id}}">

                        <button type="submit" id="add_role_to_user_button" disabled class="btn btn-primary disabled">Submit</button>
                    </form>

                </div>


                <!-- /.card-body -->
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List User Roles</h3>
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
                                            Role Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Role Slug
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($user->roles as $role)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ $role->id }}</td>
                                            <td class="sorting_1">{{ $role->name }}</td>
                                            <td class="sorting_1">{{ $role->slug }}</td>

                                            <td class="sorting_1">
                                                <a href="{{ route('admin.user.remove_user_role', ['user_id' => $user->id, 'role_id' => $role->id]) }}" class="btn btn-danger">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">ID</th>
                                        <th rowspan="1" colspan="1">Role Name</th>
                                        <th rowspan="1" colspan="1">Role Slug</th>
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
@stop
@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop
@section('js')
    <script>
        const userRoleIds = "{{ json_encode($userRoleIds) }}";

        $('#project_id').on('change', function(e) {

            $('#role_id').empty();
            $("#role_id").append(new Option("Please Select a Role"));

            const project_id = e.target.value;
            const route = "/users/"+project_id+"/list_project_roles"

            $.get(route, function (data, status) {
                for (role of data) {

                    if(userRoleIds.includes(role.id)) {
                        $("#role_id").append(`<option disabled value="${role.id}">${role.name}</option>`);
                    }
                    else {
                        $("#role_id").append(`<option value="${role.id}">${role.name}</option>`);
                    }
                }

            });
        });

        $("#role_id").on('change', function (e) {

            if(!isNaN(e.target.value)) {
                $('#add_role_to_user_button').removeClass("disabled");
                $('#add_role_to_user_button').removeAttr("disabled");
            }
            else {
                $('#add_role_to_user_button').addClass("disabled");
                $('#add_role_to_user_button').attr("disabled");
            }

        });

    </script>
@stop
