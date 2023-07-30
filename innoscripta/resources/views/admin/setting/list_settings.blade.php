@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Settings</h3>
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
                                            Key
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Value
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        <tr role="row" class="odd">
                                            <td class="sorting_1">1</td>
                                            <td class="sorting_1">Public/Private Key</td>
{{--                                            <td class="sorting_1">{{ $settings->where('key', \App\Constants\SettingConstants::OAUTH_PUBLIC_KEY)->first()->value }}</td>--}}
                                            <td class="sorting_1">***************************</td>
                                            <td class="sorting_1">
                                                <a class="btn btn-warning" href="{{ route('admin.setting.form_public_private_keys') }}">Edit</a>
                                            </td>
                                        </tr>
                                    @foreach($settings as $setting)
                                        @if(!in_array($setting->key, [\App\Constants\SettingConstants::OAUTH_PUBLIC_KEY, \App\Constants\SettingConstants::OAUTH_PRIVATE_KEY]))
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">{{ $loop->index+2 }}</td>
                                                <td class="sorting_1">{{ $setting->key }}</td>
                                                <td class="sorting_1">{{ $setting->value }}</td>
                                                <td class="sorting_1">
                                                    <a
                                                        class="btn btn-warning"
                                                        href="{{ route('admin.setting.edit_form', ['id' => $setting->id]) }}"
                                                    >
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Index</th>
                                        <th rowspan="1" colspan="1">Key</th>
                                        <th rowspan="1" colspan="1">Value</th>
                                        <th rowspan="1" colspan="1">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            {{ $settings->links() }}
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
