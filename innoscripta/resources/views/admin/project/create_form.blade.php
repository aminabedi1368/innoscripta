@extends('adminlte::page')

@section('title', 'Projects')

@section('content_header')
    <h1>Create Project</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create</h3>
        </div>
        <form role="form" action="{{ route('admin.project.store') }}" method="POST">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">{{ __('admin/projects.name') }}</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="{{ __('admin/projects.name') }}">
                </div>

                <div class="form-group">
                    <label for="slug">{{ __('admin/projects.slug') }}</label>
                    <input name="slug" type="text" class="form-control" id="name" placeholder="{{ __('admin/projects.slug') }}">
                </div>

                <input type="hidden" name="is_first_party" value="0" />

                <div class="form-group">
                    <label for="is_first_party">{{ __('admin/projects.is_first_party') }}</label>
                    <input name="is_first_party" type="checkbox" id="is_first_party" value="1">
                </div>

                <div class="form-group">
                    <label for="description">{{ __('admin/projects.description') }}</label>
                    <textarea rows="4" name="description" type="text" class="form-control" id="description"></textarea>
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
