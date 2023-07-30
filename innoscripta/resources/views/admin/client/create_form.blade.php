@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create</h3>
        </div>
        <form role="form" action="{{ route('admin.client.store') }}" method="POST">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Client Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Client Name">
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input name="slug" type="text" class="form-control" id="name" placeholder="Slug">
                </div>

                <div class="form-group">
                    <label for="oauth_client_type">OAuth Client Type</label>
                    <select name="oauth_client_type" id="oauth_client_type" class="form-control">
                        <option value="{{ \App\Constants\ClientConstants::OAUTH_TYPE_CONFIDENTIAL }}">{{ \App\Constants\ClientConstants::OAUTH_TYPE_CONFIDENTIAL }}</option>
                        <option value="{{ \App\Constants\ClientConstants::OAUTH_TYPE_PUBLIC }}">{{ \App\Constants\ClientConstants::OAUTH_TYPE_PUBLIC }}</option>
                    </select>
                </div>

                <input name="project_id" type="hidden" class="form-control" value="{{ $project->id }}">

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" type="text" class="form-control" id="type">
                        @foreach(\App\Constants\ClientConstants::ALL_TYPES as $client_type)

                            <option value="{{$client_type}}">{{ $client_type }}</option>
                        @endforeach
                    </select>
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
