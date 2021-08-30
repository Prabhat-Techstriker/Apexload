@extends('layouts.webSite')
@section('content') 
	
	<header class="page_header contact_header">
		 <h1>Contact Us</h1>
	</header>
	
	<div class="container">
		<div class="contact_us">
			<div class="details_side">
				<div class="details_box">
					<h4>Mailing Address</h4>
					<p>#123, NYC Lorem ipsum 5555,<br> demo</p>
				</div>
				<div class="details_box">
					<h4>Phone no.</h4>
					<p><a href="tel: +123456789">+ 123456789</a></p>
				</div>
				<div class="details_box">
					<h4>Email</h4>
					<p><a href="mailto:info@demolorem.com">info@demolorem.com</a></p>
				</div>
			</div>
			<div class="right_side">
				@if(session('message'))
				  <div class='alert alert-success'>
				  {{ session('message') }}
				  </div>
				@endif
				@if($errors->any())
				      <div class="alert alert-danger">
				          <ul>
				          @foreach ($errors->all() as $error)
				              <li>{{ $error }}</li>
				          @endforeach
				          </ul>
				      </div>
				@endif


				<form method="post" action="{{ route('contactus') }}" id="contact" name="contact">
					  {{ csrf_field() }}
					<div class="form-group">
						<label for="name">Full Name*</label>
						<input type="text" class="form-control" name="full_name" id="name" required="" />
					</div>
					<div class="form-group">
						<label for="email">Email*</label>
						<input type="email" class="form-control" name="email" id="email"  required=""/>
					</div>
					<div class="form-group">
						<label for="subject">Subject*</label>
						<input type="text" class="form-control" name="subject" id="subject"  required=""/>
					</div>
					<div class="form-group">
						<label for="message">Message*</label>
						<textarea type="text" class="form-control" rows="5" name="message" id="message" required=""></textarea>
					</div>
					<div class="form-group">
						<input type="submit" class="btn submit_btn" value="Send Message" id="submit" />
					</div>
				</form>
			</div>	
		</div>
	</div>
	
	<div class="map">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					 <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319" frameborder="0" style="border:0"></iframe>
				</div>
			</div>
		</div>
	</div>
	
@endsection