@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Edit testimonial
    </div>

    <div class="card-body">
        <form action="{{ route("admin.testimonials.update", [$testimonial->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-6">
                    <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($testimonial) ? $testimonial->name : '') }}" required>
                    @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.name_helper') }}
                    </p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-6">
                     <label for="description">Comment</label>
                    <textarea id="description" name="description" class="form-control" required>{{ old('description', isset($testimonial) ? $testimonial->description : '') }}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }} col-md-6">
                    <label for="user_image">User Image</label>
                    <input type="file" id="user_image" name="user_image" onchange="readURL(this);" class="form-control">
                </div>
            </div>
            <div class=""> 
                @if(isset($testimonial['user_image']) !='') 
                    <img id="profileDisplay" src="{{ url('/') }}/public/testimonialsUser/{{ $testimonial->user_image}}">
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
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
.select2-container--default .select2-selection--multiple {
    border: solid #e4e7ea 1px !important;
    height: 44px !important;
}
</style>