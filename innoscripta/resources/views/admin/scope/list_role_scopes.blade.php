@extends('adminlte::page')

@section('title', 'Role Scopes')

@section('content_header')
    <h1>Role Scopes ({{ $role->name }})</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Scope</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.scope.add_scope_to_role') }}" method="POST">

                        <input name="role_id" type="hidden" value="{{ $role->id }}">
                        @csrf
                        <div class="form-group">
                            <label for="scope_id">Scope Name</label>
                            <select name="scope_id" id="scope_id" class="form-control">
                                <option selected="selected" disabled="disabled">Select Scope to Add</option>
                                @foreach($projectScopes as $scope)
                                    @if(in_array($scope->id, $roleAllScopeIds))
                                        <option disabled value="{{ $scope->id }}"> {{ $scope->name }} </option>
                                    @else()
                                        <option value="{{ $scope->id }}"> {{ $scope->name }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List Role Scopes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div></div><div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th
                                            class="
                                                @if(request()->has('sort') && request('sort') === 'id' && request('dir') === 'asc')
                                                    sorting_asc
                                                @elseif(request()->has('sort') && request('sort') === 'id' && request('dir') === 'desc')
                                                    sorting_desc
                                                @else
                                                    sorting
                                                @endif
                                                "
                                            tabindex="0"
                                            aria-controls="example2"
                                            rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                        >
                                            <a
                                                style="display: block"
                                                @if(request()->has('sort') && request('sort') === 'id' && request('dir') === 'asc')
                                                    href="/{{ request()->path() . "?sort=id&dir=desc" }}"
                                                @else
                                                    href="/{{ request()->path() . "?sort=id&dir=asc" }}"
                                                @endif
                                            >
                                                ID
                                            </a>
                                        </th>
                                        <th
                                            class="
                                                @if(request()->has('sort') && request('sort') === 'name' && request('dir') === 'asc')
                                                    sorting_asc
                                                @elseif(request()->has('sort') && request('sort') === 'name' && request('dir') === 'desc')
                                                    sorting_desc
                                                @else
                                                    sorting
                                                @endif
                                                "
                                            tabindex="0"
                                            aria-controls="example2"
                                            rowspan="1"
                                            colspan="1"

                                        >
                                            <a
                                                style="display: block"
                                                @if(request()->has('sort') && request('sort') === 'name' && request('dir') === 'asc')
                                                href="/{{ request()->path() . "?sort=name&dir=desc" }}"
                                                @else
                                                href="/{{ request()->path() . "?sort=name&dir=asc" }}"
                                                @endif
                                            >
                                                Name
                                            </a>
                                        </th>
                                        <th
                                            class="
                                            @if(request()->has('sort') && request('sort') === 'slug' && request('dir') === 'asc')
                                                sorting_asc
                                            @elseif(request()->has('sort') && request('sort') === 'slug' && request('dir') === 'desc')
                                                sorting_desc
                                            @else
                                                sorting
                                            @endif
                                            "
                                            tabindex="0"
                                            aria-controls="example2"
                                            rowspan="1"
                                            colspan="1"
                                        >
                                            <a
                                                style="display: block"
                                                @if(request()->has('sort') && request('sort') === 'slug' && request('dir') === 'asc')
                                                href="/{{ request()->path() . "?sort=slug&dir=desc" }}"
                                                @else
                                                href="/{{ request()->path() . "?sort=slug&dir=asc" }}"
                                                @endif
                                            >
                                                Slug
                                            </a>
                                        </th>
                                        <th
                                            class="
                                            @if(request()->has('sort') && request('sort') === 'description' && request('dir') === 'asc')
                                                sorting_asc
                                            @elseif(request()->has('sort') && request('sort') === 'description' && request('dir') === 'desc')
                                                sorting_desc
                                            @else
                                                sorting
                                            @endif
                                                "                                             tabindex="0"
                                            aria-controls="example2"
                                            rowspan="1"
                                            colspan="1"
                                        >
                                            <a
                                                style="display: block"
                                                @if(request()->has('sort') && request('sort') === 'description' && request('dir') === 'asc')
                                                href="/{{ request()->path() . "?sort=description&dir=desc" }}"
                                                @else
                                                href="/{{ request()->path() . "?sort=description&dir=asc" }}"
                                                @endif
                                            >
                                                Description
                                            </a>
                                        </th>
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($roleScopes as $roleScope)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{ $roleScope->scope_id }}</td>
                                            <td class="sorting_1">{{ $roleScope->name }}</td>
                                            <td class="sorting_1">{{ $roleScope->slug }}</td>
                                            <td class="sorting_1">{{ list_view_summary($roleScope->description) }}</td>
                                            <td class="sorting_1">
                                                <a class="btn btn-danger" href="{{ route('admin.scope.remove_scope_from_role', ['role_id' => $role->id, 'scope_id' => $roleScope->scope_id]) }}">Remove</a>
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
                            {{ $roleScopes->links() }}
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
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
