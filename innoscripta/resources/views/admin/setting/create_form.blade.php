@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create</h3>
        </div>
        <form role="form" action="" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">{{ __('admin/settings.name') }}</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="{{ __('admin/settings.name') }}">
                </div>

                <div class="form-group">
                    <label for="slug">{{ __('admin/settings.slug') }}</label>
                    <input name="slug" type="text" class="form-control" id="name" placeholder="{{ __('admin/settings.slug') }}">
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" name="submit_new" class="btn btn-primary" value="1">{{ __('admin/settings.submit_and_new') }}</button>
                <button type="submit" name="submit_list" class="btn btn-info" value="1">{{ __('admin/settings.submit_back_list') }}</button>
            </div>
        </form>
    </div>@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
