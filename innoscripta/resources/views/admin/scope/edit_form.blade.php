@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit Scope</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Scope</h3>
        </div>
        <form role="form" action="{{ route('admin.scope.update_scope', ['id' => $scope->id]) }}" method="POST">

            @csrf
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Scope Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{ $scope->name }}">
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input disabled name="slug" type="text" class="form-control disabled" id="slug" value="{{ $scope->slug }}">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" type="text" class="form-control" id="description" value="{{ $scope->description }}">
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
