@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="row">

        <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit User Identifier</h3>
            </div>
            <form role="form" action="" method="POST">

                @csrf
                {{ method_field('PUT') }}
                <div class="card-body">

                    <div class="form-group">
                        <label for="identifier_type">Type</label>
                        <select id="identifier_type" name="type" class="form-control" disabled>
                            <option @if($userIdentifier->type === \App\Constants\UserIdentifierType::MOBILE) selected @endif value="{{ \App\Constants\UserIdentifierType::MOBILE }}">{{ \App\Constants\UserIdentifierType::MOBILE }}</option>
                            <option @if($userIdentifier->type === \App\Constants\UserIdentifierType::EMAIL) selected @endif value="{{ \App\Constants\UserIdentifierType::EMAIL }}">{{ \App\Constants\UserIdentifierType::EMAIL }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="value">Value</label>
                        <input name="value" type="text" class="form-control @if($errors->has('value')) is-invalid @endif " id="value" value="{{ old('value', $userIdentifier->value )}}" >
                        @if($errors->has('value'))
                            <span id="terms-error" class="error invalid-feedback" style="display: inline;">{{ $errors->first('value') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="is_verified">Is Verified</label>

                        <select name="is_verified" id="is_verified" class="form-control">
                            <option @if($userIdentifier->is_verified) selected @endif value="1">Yes</option>
                            <option @if(!$userIdentifier->is_verified) selected @endif value="0">No</option>
                        </select>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit"class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
