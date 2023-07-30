@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
    <div class="row">




        <div class="col-12">
            @if(session('success_message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    {{ session('success_message') }}
                </div>
            @endif
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List Icons</h3>
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
                                            Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            File
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Upload
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <tr role="row" class="odd">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_logo" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">Logo</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="logo" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/logo.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/logo.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="logo" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_57" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 57x57</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_57" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_57.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_57.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_57" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_60" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 57x57</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_60" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_60.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_60.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_60" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_72" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 57x57</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_72" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_72.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_72.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_72" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_76" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 57x57</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_76" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_76.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_76.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_76" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>


                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_114" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 114x114</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_114" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_114.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_114.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_114" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_120" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 120x120</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_120" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_120.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_120.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_120" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>


                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_144" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 144x144</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_144" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_144.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_144.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_144" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_152" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 152x152</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_152" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_152.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_152.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_152" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_apple_touch_icon_180" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 180x180</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="apple_touch_icon_180" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/apple_touch_icon_180.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/apple_touch_icon_180.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="apple_touch_icon_180" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_android_icon_192" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">android icon 192x192</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="android_icon_192" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/android_icon_192.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/android_icon_192.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="android_icon_192" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_icon_16" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 16x16</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="icon_16" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/icon_16.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/icon_16.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="icon_16" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_icon_32" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 32x32</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="icon_32" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/icon_32.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/icon_32.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="icon_32" disabled type="submit" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>

                                        <tr role="row" class="even">
                                            <form enctype="multipart/form-data" method="POST" name="upload_file_icon_96" action="{{ route('admin.setting.upload_icon') }}">
                                                @csrf
                                                <td class="sorting_1">apple touch icon 96x96</td>
                                                <td class="sorting_1">
                                                    <input class="form-control" type="file" name="icon_96" />
                                                </td>
                                                <td class="sorting_1">
                                                    @if(file_exists( public_path() . '/storage/icons/icon_96.png'))
                                                        <img width="60" height="60" src="{{'/storage/icons/icon_96.png' }}"/>
                                                    @endif
                                                </td>
                                                <td class="sorting_1"><button id="icon_96" disabled type="submit" id="icon_96" class="btn btn-primary disabled">Submit</button></td>
                                            </form>
                                        </tr>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">File</th>
                                        <th rowspan="1" colspan="1">Upload</th>
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
        $('input').on('change', (e) => {
            $("#"+e.target.name).removeClass("disabled");
            $("#"+e.target.name).removeAttr("disabled");
        })
    </script>
@stop
