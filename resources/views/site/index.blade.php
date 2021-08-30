@extends('layouts.webSite')
@section('content') 
<header>
         <h1>find the truck load the truck</h1>
            <a href="" class="btn cstm_btn">Find Now</a>
    </header>  
	<div class="container">
		<div class="about_apex">
			<div class="image_side">
				<img src="{{ asset('/public/images/about_apex.jpg') }}" alt="Image" />
			</div>
			<div class="content_side">
				<h3>About <span>Apexloads</span></h3>
				<p>Apexloads is a loadboard that brings together Carriers, Brokers and Shipper. Price negotiations and booking will be between the parties involved and will happen off the website. Our goal is a platform that simply brings the three parties together.</p>
				<a href="">Learn More <i class="fas fa-arrow-right"></i></a>
			</div>
		</div>
	</div>
	
	<div class="three_boxes">
		<div class="container">
			<div class="main_heading">Lorem ipsum dolor sit amet</div>
		</div>
		<div class="container">
			<div class="three_boxes_main">
				<div class="three_boxes_outer">
					<div class="img_outer">
						<img src="{{ asset('/public/images/carrier.jpg') }}" alt="Image" />
					</div>
					<h2>Carrier</h2>
					<p>Company or individual (Owner Operator) who transports good for hire.</p>
					<a href="">Start Now <i class="fas fa-arrow-right"></i></a>
				</div>
				
				<div class="three_boxes_outer">
					<div class="img_outer">
						<img src="{{ asset('/public/images/broker.jpg') }}" alt="Image" />
					</div>
					<h2>Broker</h2>
					<p>Company or individual who finds carriers to transport goods on behalf of a shipper/ freight forwader</p>
					<a href="">Start Now <i class="fas fa-arrow-right"></i></a>
				</div>
				
				<div class="three_boxes_outer">
					<div class="img_outer">
						<img src="{{ asset('/public/images/shipper.jpg') }}" alt="Image" />
					</div>
					<h2>Shipper</h2>
					<p>Company who manufactures goods and requires to transported from point A to B</p>
					<a href="">Start Now <i class="fas fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="testimonials">
		<div class="container">
			<div class="main_heading">Lorem ipsum dolor sit amet</div>
		</div>
		<div class="container">
			<div class="owl-carousel testimonials-carousel">
				<div class="content_slide">
					<i class="fas fa-quote-left"></i>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<div class="author">
						<img src="{{ asset('/public/images/author.jpg') }}" />Jack mack
					</div>
				</div>
				<div class="content_slide">
					<i class="fas fa-quote-left"></i>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<div class="author">
						<img src="{{ asset('/public/images/author.jpg') }}" />Jack mack
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="dwnd_app container">
		<div class="row">
			<div class="col-lg-4 col-md-6 offset-md-6">
				<h3>Lorem ipsum dolor sit amet</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<div class="dwnd_icons">
					<a href=""><img src="{{ asset('/public/images/app_store.png') }}" alt="Image" /></a>
					<a href=""><img src="{{ asset('/public/images/g_play.png') }}" alt="Image" /></a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="newsletter container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<div class="main_heading">our newsletter</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				@if(session('message'))
				  <div class='alert alert-success'>
				  {{ session('message') }}
				  </div>
				@endif
				<form method="post" action="{{ route('newslatter') }}" id="newsletter" name="newsletter">
					{{ csrf_field() }}
					<input type="email" name="email" class="form-control" placeholder="Enter your email here.." required="" />
					<input type="submit" value="" class="submit_btn" />
				</form>
			</div>
		</div>
	</div>
 
	@endsection