@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop


@section('content')

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List Projects</h3>

                    <a class="btn btn-success float-right" href="{{ route('admin.project.create_form') }}">Create Project</a>
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
                                            Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Slug
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Project ID
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Creator User
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Is First Party
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ $project->id }}</td>
                                            <td class="sorting_1">{{ $project->name }}</td>
                                            <td class="sorting_1">{{ $project->slug }}</td>
                                            <td class="sorting_1">{{ $project->project_id }}</td>
                                            <td class="sorting_1">{{ $project->creatorUser->fullname }}</td>
                                            <td class="sorting_1">
                                                {{ $project->is_first_party ? "YES" : "NO" }}
                                            </td>
                                            <td class="sorting_1">
                                                <a class="btn btn-info" href="{{ route('admin.client.list_project_clients', ['project_id' => $project->id]) }}">Clients</a>
                                                <a class="btn btn-dark" href="{{ route('admin.role.list_project_roles', ['project_id' => $project->id]) }}">Roles</a>
                                                <a class="btn btn-primary" href="{{ route('admin.scope.list_project_scopes', ['project_id' => $project->id]) }}">Scopes</a>
                                                <a class="btn btn-warning" href="{{ route('admin.project.edit_form', ['id' => $project->id]) }}">Edit</a>

                                                @if($project->id === 1)
                                                    <a disabled="disabled" style="pointer-events: auto;" title="You cant delete this project" class="btn btn-danger disabled" href="#">Remove</a>
                                                @else
                                                    <a class="btn btn-danger" href="{{ route('admin.project.delete_project', ['id' => $project->id]) }}">Remove</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">ID</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Slug</th>
                                        <th rowspan="1" colspan="1">Project ID</th>
                                        <th rowspan="1" colspan="1">Creator User</th>
                                        <th rowspan="1" colspan="1">Is First Party</th>
                                        <th rowspan="1" colspan="1">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            {{ $projects->links() }}
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
