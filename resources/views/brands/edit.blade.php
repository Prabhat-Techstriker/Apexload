@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Edit Brand
    </div>
    <div class="card-body">
        <form action="{{ route("admin.brands.update", [$brands->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : '' }} col-md-12">
                    <label for="brand_name">Brand Name<span>*</span></label>
                    <input type="text" id="brand_name" name="brand_name" class="form-control" value="{{ old('brand_name', isset($brands) ? $brands->brand_name : '') }}" required>
                    @if($errors->has('brand_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('brand_name') }}
                    </em>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                    <label for="description">Brand Description</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description', isset($brands) ? $brands->description : '') }}</textarea>
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

