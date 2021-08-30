@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Create Responsbility
        <div class="pull-right">
            <a class="btn btn-primary" href="{{url('admin/all-responsibility')}}"> Back</a>
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
        <form action="{{ route("admin.responsibility.addresponsibility") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="form-row">
                    <div class="form-group {{ $errors->has('responsibility_type') ? 'has-error' : '' }} col-md-12">
                        <label for="responsibility_type">Responsbility Type</label>
                        <input type="text" id="responsibility_type" name="responsibility_type" class="form-control" placeholder="Responsbility Type" required>
                    </div>
                    <div class="form-group {{ $errors->has('responsibility_description') ? 'has-error' : '' }} col-md-12">
                        <label for="responsibility_description">Responsbility Description</label>
                        <textarea type="text" id="responsibility_description" name="responsibility_description" class="form-control" placeholder="Responsbility Description"></textarea>
                    </div>
                    
                </div>
            </div>
            <div><button type="submit" class="btn btn-success">Save</button></div>
        </form>
    </div>
</div>
@endsection