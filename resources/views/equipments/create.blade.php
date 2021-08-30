@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Create Equipment
        <div class="pull-right">
            <a class="btn btn-primary" href="{{url('admin/equipments')}}"> Back</a>
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
        <form action="{{ route("admin.equipments.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="form-row">
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }} col-md-12">
                        <label for="type">Equipment Type</label>
                        <input type="text" id="type" name="type" class="form-control" placeholder="Equipment Type" required>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                        <label for="description">Equipment Description</label>
                        <textarea type="text" id="description" name="description" class="form-control" placeholder="Equipment Description"></textarea>
                    </div>
                    
                </div>
            </div>
            <div><button type="submit" class="btn btn-success">Save</button></div>
        </form>
    </div>
</div>
@endsection