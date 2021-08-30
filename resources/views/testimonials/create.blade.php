@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Create Testimonials
        <div class="pull-right">
            <a class="btn btn-primary" href="{{url('testimonials')}}"> Back</a>
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
        <form action="{{ route("admin.testimonials.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="form-row">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-12">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                        <label for="description">Comment</label>
                        <textarea type="text" id="description" name="description" class="form-control" placeholder="Comment"></textarea>
                    </div>
                    <div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }} col-md-12">
                        <label for="user_image">User Image</label>
                        <input type="file" id="user_image" name="user_image" onchange="readURL(this);" class="form-control">
                    </div>
                    <div class="">
                     <img id="profileDisplay" src="#" style="display: none;">
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
    /* width: 112%; */
    border-radius: 50%;
    margin-bottom: 15px;
}
</style>