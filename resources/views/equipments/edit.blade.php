@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Edit Brand
    </div>
    <div class="card-body">
        <form action="{{ route("admin.equipments.update", [$equipments->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }} col-md-12">
                    <label for="type">Equipment Type<span>*</span></label>
                    <input type="text" id="type" name="type" class="form-control" value="{{ old('type', isset($equipments) ? $equipments->type : '') }}" required>
                    @if($errors->has('type'))
                    <em class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </em>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                    <label for="description">Equipment Description</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description', isset($equipments) ? $equipments->description : '') }}</textarea>
                    @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                    @endif
                </div>
            </div>
            <div>
                <input class="btn btn-success" type="submit" value="Update" style="float: right;">
            </div>
        </form> 

    </div>
</div>
@endsection

