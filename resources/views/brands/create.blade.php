@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Create Brands
        <div class="pull-right">
            <a class="btn btn-primary" href="{{url('admin/brands')}}"> Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
        <form action="{{ route("admin.brands.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="form-row">
                    <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : '' }} col-md-12">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-control" placeholder="Brand Name" required>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                        <label for="description">Brand Description</label>
                        <textarea type="text" id="description" name="description" class="form-control" placeholder="Brand Description"></textarea>
                    </div>
                    
                </div>
            </div>
            <div><button type="submit" class="btn btn-success">Save</button></div>
        </form>
    </div>
</div>
@endsection