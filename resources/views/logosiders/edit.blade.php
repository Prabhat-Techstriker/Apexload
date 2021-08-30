@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Upload Logo
    </div>

    <div class="card-body">
        <form action="{{ route("admin.logoslider.update", [$logo->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="filenames">Upload Logo*</label>
                <input type="file" id="filenames" name="filenames" class="form-control" required>
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection