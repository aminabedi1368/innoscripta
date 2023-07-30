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
        <form role="form" action="{{ route('admin.scope.store_scope', ['project_id' => $project->id]) }}" method="POST">

            @csrf
{{--            {{ method_field('PUT') }}--}}

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Scope Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Scope Name">
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input name="slug" type="text" class="form-control" id="slug" placeholder="Slug">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" type="text" class="form-control" id="description" placeholder="Description">
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
