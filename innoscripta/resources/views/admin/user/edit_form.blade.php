@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>
        <form role="form" action="{{ route('admin.user.update_user' , ['id' => $user->id ]) }}" method="POST">
            @csrf
            {{ method_field('PUT') }}
            <div class="card-body">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input name="first_name" type="text" class="form-control" id="first_name" value="{{ $user->first_name }}">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input name="last_name" type="text" class="form-control" id="last_name" value="{{ $user->last_name }}">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option @if($user->status === \App\Constants\UserStatus::LOCKED) selected @endif value="{{ \App\Constants\UserStatus::LOCKED }}">{{ \App\Constants\UserStatus::LOCKED }}</option>
                        <option @if($user->status === \App\Constants\UserStatus::ACTIVE) selected @endif value="{{ \App\Constants\UserStatus::ACTIVE }}">{{ \App\Constants\UserStatus::ACTIVE }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="last_name" for="is_super_admin" >Is Super Admin</label>
                    <select name="is_super_admin" id="is_super_admin" class="form-control">
                        <option @if($user->is_super_admin) selected @endif value="1">YES</option>
                        <option @if(!$user->is_super_admin) selected @endif value="0">NO</option>
                    </select>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Change User Password</h3>
        </div>
        <form role="form" action="{{ route('admin.user.change_password', ['id' => $user->id ]) }}" id="change_password_form" method="POST">
            @csrf
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input name="password" type="text" class="form-control" id="password" typeof="password" value="">
                </div>

            </div>

            <div class="card-footer">
                <button
                    data-target="#modal-danger"
                    type="button"
                    id="change_password_btn"
                    data-toggle="modal"
                    class="btn btn-primary disabled"
                    disabled
                >
                    Submit
                </button>
            </div>
        </form>
    </div>


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Upload User Avatar</h3>
        </div>
        <form enctype="multipart/form-data" role="form" action="{{ route('admin.user.upload_avatar', ['id' => $user->id ]) }}" id="upload_avatar" method="POST">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="avatar">Select a file to upload</label>
                    <input name="avatar" type="file" class="form-control" id="avatar">
                </div>

                <img alt="user avatar" width="100px" height="100px" src="@if($user->avatar){{\Illuminate\Support\Facades\Storage::url($user->avatar)}}@else{{"/storage/avatar/avatar_user.png"}}@endif" />
            </div>

            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>



    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Danger Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to change this user password ?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="update_password">Update</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script>
        const password_input = $('#password');
        const submitPasswordButton = $('#change_password_btn');
        const change_password_form = $('#change_password_form');

        setSubmitPasswordButtonState();

        password_input.keyup(function() {
            setSubmitPasswordButtonState();
        });

        $('#update_password').click(function() {
            change_password_form.submit();
        });


        function setSubmitPasswordButtonState()
        {
            const submitPasswordButton = $('#change_password_btn');

            if(password_input.val() !== "") {
                submitPasswordButton.prop("disabled", false);
                submitPasswordButton.removeClass("disabled");
            }
            else {
                submitPasswordButton.prop("disabled", true);
                submitPasswordButton.addClass("disabled");
            }
        }

    </script>
@stop
