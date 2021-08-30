@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.driver.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', isset($user) ? $user->first_name : '') }}" required>
                    @if($errors->has('first_name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('first_name') }}
                        </em>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" disabled="">
                    
                </div>
                <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }} col-md-4">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number', isset($user) ? $user->phone_number : '') }}" disabled="">
                </div>
            </div>
            <div class="form-row">
              
                <div class="form-group {{ $errors->has('profile_image') ? 'has-error' : '' }} col-md-6">
                    <label for="profile_image">Profile Image</label>
                    <input type="file" id="profile_image" name="profile_image" onchange="readURL(this);" class="form-control">
                </div>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }} col-md-6">
                    <label for="address">Address</label>
                    <input type="text" id="address"  class="form-control" name="address" value="{{ old('address', isset($user) ? $user->address : '') }}">
                </div>
            </div>
            
            <div class=""> 
                @if(isset($user['profile_image']) !='') 
                    <img id="profileDisplay" src="{{ url('/') }}/storage/app/{{ old('profile_image', isset($user) ? $user->profile_image : 'N.A') }}">
                @else
                    <img id="profileDisplay" src="{{ url('storage/app/images') }}/avatar-dummy.png">      
                @endif
            </div>
            <div>
                <input class="btn btn-success" type="submit" value="{{ trans('global.save') }}">
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
    width: 160px;
    border-radius: 50%;
    height: 160px;
    object-fit: cover;
}
.select2-container--default .select2-selection--multiple {
    border: solid #e4e7ea 1px !important;
    height: 44px !important;
}
</style>