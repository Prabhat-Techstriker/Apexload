@extends('layouts.webloging')
@section('content') 

<header class="page_header contact_header">
<h1>Create Profile</h1>
</header>
<div class="container">

	@include('flash-message')
	@if (session()->has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
	<form method="post" action="{{ url('/') }}/web/webupdateProfile" id="createprofile" name="" enctype="multipart/form-data">
	<div class="contact_us createpro">
			<div class="details_side">
			    <div class="img-upload">
			        <div class="circle">
			        	<?php if($user->profile_image != ""){  ?>
			        		 <img class="profile-pic" src="{{ url('/') }}/storage/app/{{ $user->profile_image }}">
			          
			           <?php } else {  ?>
                          <img class="profile-pic" src="{{ url('/') }}/storage/app/images/avatar-dummy.png">
						<?php } ?>
			           
			        </div>
			        <div class="p-image">
			            <i class="fa fa-camera upload-button"></i>
			            <input class="file-upload" type="file" name="user_image" accept="image/*"/>
			        </div>
			    </div>
			</div>
		    <div class="right_side">
			    {{ csrf_field() }}
			    <div class="form-row">
					<div class="form-group col-md-6">
						<label for="firstname">First name*</label>
						<input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" />
					</div>
					<div class="form-group col-md-6">
						<label for="lastname">Last name</label>
						<input type="text" name="last_name" class="form-control" value="{{$user->last_name}}"/>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="email">Email*</label>
						<?php if($user->email != ""){  ?>
							<input type="email" class="form-control" value="{{$user->email}}" disabled/>
						<?php } else {  ?>
                          <input type="email" name="email" class="form-control" value="" />
						<?php } ?>
					</div>
					<div class="form-group col-md-6">
						<label for="phone_number">Phone number with country code</label>
						<?php if($user->phone_number != ""){  ?>
							<input type="text" class="form-control" value="{{$user->phone_number}}" disabled/>
						<?php } else {  ?>
                          <input type="text" name="phone_number" class="form-control" value="" />
						<?php } ?>

					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="responsbility">Responsbility*</label>
						<select class="form-control" id="responsbilityType" name="responsibilty_type" <?php if($user->responsibilty_type != ""){ echo 'disabled'; } else { echo "required";} ?>>
                            <option value="">Please Select Responsbility</option>
                            @foreach($responsibilities as $responsibility)
                            <option value="{{ $responsibility->id }}" <?php if($user->responsibilty_type == $responsibility->id) echo " selected"?>>{{ $responsibility->responsibility_type}}</option>
                            @endforeach
                        </select>
					</div>
					<div class="form-group col-md-6">
						<label for="accounttype">Account Type*</label>
						<?php if($user->account_type != "") { ?>
                         <select class="form-control" disabled>
						    <option> <?php 
						    if($user->account_type == 1){
						    	echo "Individual";
						    } elseif($user->account_type == 2){
                                echo "Fleet Manager";
						    }elseif($user->account_type == 3){
                                echo "Individual";
						    }elseif($user->account_type == 4){
                                echo "Brokers";
						    } elseif($user->account_type == 5){
                                echo "Factory";
						    } ?>
						    </option>
					    </select>
						<?php } else { ?>
                        <select name="account_type" id="accounttype" class="form-control" required disabled>
						 <option>Choose Account Type</option>
					    </select>
                        <?php } ?>
					</div>
				</div>
				<div class="form-group">
					<input type="submit" class="btn submit_btn" value="submit" id="submit" />
				</div>
		    </div>	
		
	</div>
	</form>
</div>
@endsection
