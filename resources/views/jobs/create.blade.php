@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Create Project
        <div class="pull-right">
            <a class="btn btn-primary" href="{{url('projects')}}"> Back</a>
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
        <form action="{{ route("admin.projects.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="form-row">
                    <div class="form-group {{ $errors->has('project_name') ? 'has-error' : '' }} col-md-12">
                        <label for="project_name">Project Name</label>
                        <input type="text" id="project_name" name="project_name" class="form-control" placeholder="Project Name" required>
                    </div>
                    <div class="form-group {{ $errors->has('project_description') ? 'has-error' : '' }} col-md-12">
                        <label for="project_description">Project Description</label>
                        <textarea type="text" id="project_description" name="project_description" class="form-control" placeholder="Project Description"></textarea>
                    </div>
                    
                </div>
            </div>
            <div class="">
                <img id="profileDisplay" src="#" style="display: none;">
            </div>
            <div><button type="submit" class="btn btn-success">Save</button></div>
        </form>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profileDisplay').show();
                $('#profileDisplay').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
   
</script>
<style type="text/css">
    img#profileDisplay {
    width: 15%;
    border-radius: 50%;
}
</style>