@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List Clients</h3>

                    <a class="btn btn-success float-right" href="{{ route('admin.client.create_form', ['project_id' => $project->id]) }}">Create New Client</a>
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
                                            TYPE
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            OAUTH Client TYPE
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            CLIENT ID
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Is Active
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Redirect Urls
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($clients as $client)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ ($loop->index + 1) }}</td>
                                            <td class="sorting_1">{{ $client->name }}</td>
                                            <td class="sorting_1">{{ $client->slug }}</td>
                                            <td class="sorting_1">{{ $client->type }}</td>
                                            <td class="sorting_1">{{ $client->oauth_client_type }}</td>
                                            <td class="sorting_1">{{ $client->client_id }}</td>
                                            <td class="sorting_1">
                                                {{ $client->is_active ? "YES" : "NO" }}
                                            </td>
                                            <td class="sorting_1">{{ list_view_summary(implode(',', $client->redirect_urls) )}}</td>
                                            <td class="sorting_1">
                                                <a class="btn btn-warning" href="{{ route('admin.client.update_client', ['id' => $client->id]) }}">Edit</a>

                                                @if($client->id === 1)
                                                    <a disabled="disabled" style="pointer-events: auto;" title="You cant delete this client" class="btn btn-danger disabled" href="#">Remove</a>
                                                @else
                                                    <a class="btn btn-danger" href="{{ route('admin.client.delete_client', ['id' => $client->id]) }}">Remove</a>
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
                                        <th rowspan="1" colspan="1">Type</th>
                                        <th rowspan="1" colspan="1">OAUTH Client TYPE</th>
                                        <th rowspan="1" colspan="1">CLIENT ID</th>
                                        <th rowspan="1" colspan="1">Is Active</th>
                                        <th rowspan="1" colspan="1">Redirect Urls</th>
                                        <th rowspan="1" colspan="1">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            {{ $clients->links() }}
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
