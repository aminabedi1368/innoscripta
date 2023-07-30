@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit</h3>
            </div>
            <form role="form" action="{{ route('admin.setting.update_public_private_keys') }}" method="POST">

                @csrf
                {{ method_field('PUT') }}

                <div class="card-body">
                    <div class="form-group">
                        <label for="public_key">Public Key</label>
                        <textarea rows="6" name="public_key" type="text" class="form-control" id="public_key">{{ $publicKey->value }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="private_key">Private Key</label>
                        <textarea rows="15" name="private_key" type="text" class="form-control" id="private_key">{{ $privateKey->value }}</textarea>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        </div>

        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Generate Keys</h3>
                </div>
                <div class="card-body">
                    <form id="generate_keys" role="form" action="{{ route('admin.setting.update_public_private_keys') }}" method="POST">

                        @csrf
                        <div class="form-group">
                            <label for="digest_alg">Digest algorithm</label>
                            <select name="digest_alg" id="digest_alg" class="form-control">
                                @foreach(\App\Constants\PublicPrivateKeys::ALL_DIGEST_ALG as $alg)
                                    <option value="{{$alg}}">{{$alg}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="private_keys_length">Digest algorithm</label>
                            <select name="private_keys_length" id="private_keys_length" class="form-control">
                                @foreach(\App\Constants\PublicPrivateKeys::ALL_PRIVATE_KEY_BITS as $bits)
                                    <option value="{{$bits}}">{{$bits}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="card-footer">
                            <button id="generate_button" type="button" class="btn btn-warning">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop
@section('js')
    <script>

        $('#generate_button').click(function() {

            const url = "{{ route('admin.setting.generate_public_private_key') }}";
            const data = $.post(url, $('#generate_keys').serialize(), function(res) {
                $('#public_key').val(res.public_key);
                $('#private_key').val(res.private_key);
            });
        });

    </script>
@stop
