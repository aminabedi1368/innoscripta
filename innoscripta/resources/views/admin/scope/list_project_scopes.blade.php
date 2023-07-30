@extends('adminlte::page')

@section('title', 'Project Scopes')

@section('content_header')
<h1>Scopes</h1>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Project Scopes</h3>

                <a class="btn btn-success float-right" href="{{ route('admin.scope.create_form', ['project_id' => $project->id]) }}">Add Scope</a>
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
                                        Description
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                        Actions
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($scopes as $scope)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ $scope->id }}</td>
                                    <td class="sorting_1">{{ $scope->name }}</td>
                                    <td class="sorting_1">{{ $scope->slug }}</td>
                                    <td class="sorting_1">{{ list_view_summary($scope->description) }}</td>
                                    <td class="sorting_1">
                                        <a class="btn btn-warning" href="{{ route('admin.scope.edit_form', ['id' => $scope->id]) }}">Edit</a>
                                        <a class="btn btn-danger" href="{{ route('admin.scope.delete_scope', ['id' => $scope->id]) }}">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Name</th>
                                    <th rowspan="1" colspan="1">Slug</th>
                                    <th rowspan="1" colspan="1">Description</th>
                                    <th rowspan="1" colspan="1">Actions</th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                    <div class="row">
                        {{ $scopes->links() }}
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
