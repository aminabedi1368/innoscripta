@extends('adminlte::page')

@section('title', 'User Identifiers')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create</h3>
        </div>
        <form role="form" action="{{ route('admin.user_identifier.store_user_identifier') }}" method="POST">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="identifier_type">Identifier Type</label>
                    <select class="form-control" name="type" id="identifier_type">
                        <option value="{{ \App\Constants\UserIdentifierType::EMAIL }}">{{ \App\Constants\UserIdentifierType::EMAIL }}</option>
                        <option value="{{ \App\Constants\UserIdentifierType::MOBILE }}">{{ \App\Constants\UserIdentifierType::MOBILE }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="identifier_value">Identifier Value</label>
                    <input name="value" type="text" class="form-control" id="identifier_value" placeholder="Identifier Value">
                </div>


                <input name="user_id" type="hidden" value="{{ request()->route()->parameters['user_id'] }}">

                <input type="hidden" name="is_verified" value="0" />

                <div class="form-group">
                    <label for="is_verified">Is Verified</label>
                    <input name="is_verified" type="checkbox" id="is_verified" value="1">
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
