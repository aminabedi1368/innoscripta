@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit Role</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>
        <form role="form" action="{{ route('admin.role.update_role', ['id' => $role->id]) }}" method="POST">

            @csrf
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{ $role->name }}">
                </div>

                <input type="hidden" name="project_id" value="{{ $role->project_id }}">

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input name="slug" type="text" class="form-control" id="slug" value="{{ $role->slug }}">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" type="text" class="form-control" id="description" value="{{ $role->description}}">
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
