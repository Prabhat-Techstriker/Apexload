@extends('layouts.webSite')
@section('content') 
	
	<header class="page_header about_header">
		 <h1>About Us</h1>
	</header>
	
	<div class="container">
		<div class="about_us">
			<div class="content_side">
				<div class="main_heading">Apexloads</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="image_side">
				<img src="{{ asset('/public/images/about_us_truck.jpg') }}" alt="Image" />
			</div>
		</div>
	</div>
	
	<div class="about_us_middle">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>	
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="about_us_facts">
			<div class="about_us_facts_box">
				<div class="count">
					10
				</div>	
				<div class="content">
					years in business
				</div>	
			</div>
			<div class="about_us_facts_box">
				<div class="count">
					99<sup>%</sup>
				</div>	
				<div class="content">
					customer satisfaction
				</div>	
			</div>
			<div class="about_us_facts_box">
				<div class="count">
					1M+
				</div>	
				<div class="content">
					Active Users
				</div>	
			</div>
			<div class="about_us_facts_box">
				<div class="count">
					50M+
				</div>	
				<div class="content">
					annual loads
				</div>	
			</div>
		</div>
	</div>
	
	<div class="about_us_bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<img src="{{ asset('/public/images/about_us_bottom.jpg') }}" alt="Image" />
				</div>
				<div class="col-lg-12">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>	
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="owl-carousel brands-carousel">
			<div class="brand_slide">
				<img src="{{ asset('/public/images/brand_1.png') }}" alt="Brand Logo" />
			</div>
			<div class="brand_slide">
				<img src="{{ asset('/public/images/brand_2.png') }}" alt="Brand Logo" />
			</div>
			<div class="brand_slide">
				<img src="{{ asset('/public/images/brand_3.png') }}" alt="Brand Logo" />
			</div>
			<div class="brand_slide">
				<img src="{{ asset('/public/images/brand_4.png') }}" alt="Brand Logo" />
			</div>
			<div class="brand_slide">
				<img src="{{ asset('/public/images/brand_5.png') }}" alt="Brand Logo" />
			</div>
			<div class="brand_slide">
				<img src="{{ asset('/public/images/brand_1.png') }}" alt="Brand Logo" />
			</div>
		</div>
	</div>
@endsection