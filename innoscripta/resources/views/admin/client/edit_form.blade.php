@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <h1>Client "{{ $client->name }}"</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>
        <form role="form" action="{{ route('admin.client.update_client', ['id' => $client->id]) }}" method="POST">

            @csrf
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{ $client->name }}">
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input disabled name="slug" type="text" class="form-control" id="slug" value="{{ $client->slug }}">
                </div>

                <div class="form-group">
                    <label for="client_id">Client ID</label>
                    <input disabled name="client_id" type="text" class="form-control" id="client_id" value="{{ $client->client_id }}">
                </div>


                <div class="form-group">
                    <label for="client_secret">Client Secret</label>
                    <input disabled name="client_secret" type="text" class="form-control" id="client_secret" value="{{ $client->client_secret }}">
                </div>


                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" disabled>
                        @foreach(\App\Constants\ClientConstants::ALL_TYPES as $client_type)
                            <option @if($client->type === $client_type) selected @endif value="{{$client_type}}">{{ $client_type }}</option>
                        @endforeach
                    </select>
                </div>

{{--                <div class="form-group">--}}
{{--                    <label for="oauth_client_type">Redirect Urls (comma separated)</label>--}}
{{--                    <textarea class="form-control"></textarea>--}}
{{--                </div>--}}

                <div class="form-group">
                    <label for="oauth_client_type">OAuth Client Type</label>
                    <select name="oauth_client_type" id="oauth_client_type" class="form-control">
                        <option @if($client->oauth_client_type === \App\Constants\ClientConstants::OAUTH_TYPE_CONFIDENTIAL) selected @endif value="{{ \App\Constants\ClientConstants::OAUTH_TYPE_CONFIDENTIAL }}">{{ \App\Constants\ClientConstants::OAUTH_TYPE_CONFIDENTIAL }}</option>
                        <option @if($client->oauth_client_type === \App\Constants\ClientConstants::OAUTH_TYPE_PUBLIC) selected @endif value="{{ \App\Constants\ClientConstants::OAUTH_TYPE_PUBLIC }}">{{ \App\Constants\ClientConstants::OAUTH_TYPE_PUBLIC }}</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="is_active">Is Active</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option @if($client->is_active) selected @endif value="1">Yes</option>
                        <option @if(!$client->is_active) selected @endif value="0">No</option>
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
