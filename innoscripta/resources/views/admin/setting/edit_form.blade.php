@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>
        <form role="form" action="{{ route('admin.setting.update_settings', ['id' => $setting->id]) }}" method="POST">

            @csrf
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="key">Key</label>
                    <input name="key" type="text" class="form-control" id="key" disabled value="{{ $setting->key }}">
                </div>

                <div class="form-group">
                    <label for="value">Value</label>

                    @if(strlen($setting->value) < 300)
                        <input name="value" type="text" class="form-control" id="value" value="{{ $setting->value }}">
                    @else
                        <textarea rows="6" name="value" class="form-control" >{{$setting->value}}</textarea>
                    @endif
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
