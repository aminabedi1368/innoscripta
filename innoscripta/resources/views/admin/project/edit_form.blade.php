@extends('adminlte::page')

@section('title', 'Projects')

@section('content_header')
    <h1>Edit Project</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>
        <form role="form" action="{{ route('admin.project.update_project', ['id' => $project->id]) }}" method="POST">

            @csrf
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="name">{{ __('admin/projects.name') }}</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{ $project->name }}">
                </div>

                <div class="form-group">
                    <label for="slug">{{ __('admin/projects.slug') }}</label>
                    <input name="slug" type="text" class="form-control" id="name" value="{{ $project->slug}}">
                </div>

                <input type="hidden" name="is_first_party" value="0" />

                <div class="form-group">
                    <label for="is_first_party">{{ __('admin/projects.is_first_party') }}</label>

                    <select name="is_first_party" id="is_first_party" class="form-control">
                        <option @if($project->is_first_party) selected @endif value="1">Yes</option>
                        <option @if(!$project->is_first_party) selected @endif value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">{{ __('admin/projects.description') }}</label>
                    <textarea rows="4" name="description" type="text" class="form-control" id="description">{{ $project->description }}</textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop
