@extends('layouts.webloging')
@section('content') 
<header class="page_header contact_header">
<h1>Hi, {{$user->first_name}} {{$user->last_name}}</h1>
</header>
<!-- <div class="container-fluid"> -->
<div class="">
	<div class="user-dash">
		<div class="common_side_sec">
			<?php if($user->responsibilty_type == 1 ) { ?>
				@include('partials.shippersidebar')
				
			<?php } else { ?>
				@include('partials.driversidebar')
			<?php } ?>
		</div>
		<div class="common_content_sec">
			 <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-6 col-sm-6 mb-6">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                My Requests
              </div>
              <!-- <div class="mr-5">26 New Messages!</div> -->
              <div class="mr-5">{{$totalRequest}}</div>
            </div>
            <!-- <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a> -->
          </div>
        </div>

		<?php if($user->responsibilty_type == 1 ) { ?>
		<div class="col-xl-6 col-sm-6 mb-6">
			<div class="card text-white bg-warning o-hidden h-100">
				<div class="card-body">
					<div class="card-body-icon">
						My Post Loads
					</div>
					<div class="mr-5">{{ $job }}</div>
				</div>
			</div>
		</div>
		<?php } else { ?>
		<div class="col-xl-6 col-sm-6 mb-6">
			<div class="card text-white bg-warning o-hidden h-100">
				<div class="card-body">
					<div class="card-body-icon">
						My Post Trucks
					</div>
					<div class="mr-5">{{ $job }}</div>
				</div>
			</div>
		</div>
		<?php } ?>
        <!-- <div class="col-xl-6 col-sm-6 mb-6">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-shopping-cart"></i>
              </div>
              <div class="mr-5">123 New Orders!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 mb-6">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-support"></i>
              </div>
              <div class="mr-5">13 New Tickets!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div> -->
      </div>
		</div>
	</div>
</div>

@endsection
<style>
	.user-dash.row {
    margin-bottom: 12rem;
}
	.mb-6 {
    margin-top: 2rem;
}

	.sidebar .dropdown-toggle {
	width: 100%;
}
.sidebar .dropdown-menu {
	width: 100%;
}

@media (min-width: 768px) {
	.sidebar.sidebar-sm .dropdown-toggle {
		display: none;
	}
	.sidebar.sidebar-sm .dropdown-menu {
		border-width: 0px;
		box-shadow: none;
		display: block;
		position: relative;
		width: 100%;
		z-index: 0;
	}
	.sidebar.sidebar-sm .dropdown-menu .dropdown-header {
		font-size: 16px;
		font-weight: 600;
    padding: 15px 10px 10px;
	}
	.sidebar.sidebar-sm .dropdown-menu .dropdown-header:first-child {
		padding-top: 0px;	
	}
	.sidebar.sidebar-sm .dropdown-menu .divider {
		display: none;	
	}
	.sidebar.sidebar-sm .dropdown-menu li a {
		position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
	}
	.sidebar.sidebar-sm .dropdown-menu li a:focus, 
	.sidebar.sidebar-sm .dropdown-menu li a:hover {
    color: #555;
    text-decoration: none;
    background-color: #f5f5f5;
	}
	.sidebar.sidebar-sm .dropdown-menu li a:focus, 
	.sidebar.sidebar-sm .dropdown-menu li a:hover {
    color: #555;
    text-decoration: none;
    background-color: #f5f5f5;
	}
	.sidebar.sidebar-sm .dropdown-menu li.active a, 
	.sidebar.sidebar-sm .dropdown-menu li.active a:focus, 
	.sidebar.sidebar-sm .dropdown-menu li.active a:hover {
    z-index: 2;
    color: #fff;
    background-color: #337ab7;
    border-color: #337ab7;
	}
}
@media (min-width: 992px) {
	.sidebar.sidebar-md .dropdown-toggle {
		display: none;
	}
	.sidebar.sidebar-md .dropdown-menu {
		border-width: 0px;
		box-shadow: none;
		display: block;
		position: relative;
		width: 100%;
		z-index: 0;
	}
	.sidebar.sidebar-md .dropdown-menu .dropdown-header {
		font-size: 16px;
		font-weight: 600;
    padding: 15px 10px 10px;
	}
	.sidebar.sidebar-md .dropdown-menu .dropdown-header:first-child {
		padding-top: 0px;	
	}
	.sidebar.sidebar-md .dropdown-menu .divider {
		display: none;	
	}
	.sidebar.sidebar-md .dropdown-menu li a {
		position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
	}
	.sidebar.sidebar-md .dropdown-menu li a:focus, 
	.sidebar.sidebar-md .dropdown-menu li a:hover {
    color: #555;
    text-decoration: none;
    background-color: #f5f5f5;
	}
	.sidebar.sidebar-md .dropdown-menu li a:focus, 
	.sidebar.sidebar-md .dropdown-menu li a:hover {
    color: #555;
    text-decoration: none;
    background-color: #f5f5f5;
	}
	.sidebar.sidebar-md .dropdown-menu li.active a, 
	.sidebar.sidebar-md .dropdown-menu li.active a:focus, 
	.sidebar.sidebar-md .dropdown-menu li.active a:hover {
    z-index: 2;
    color: #fff;
    background-color: #337ab7;
    border-color: #337ab7;
	}
}
@media (min-width: 1200px) {
	.sidebar.sidebar-lg .dropdown-toggle {
		display: none;
	}
	.sidebar.sidebar-lg .dropdown-menu {
		border-width: 0px;
		box-shadow: none;
		display: block;
		position: relative;
		width: 100%;
		z-index: 0;
	}
	.sidebar.sidebar-lg .dropdown-menu .dropdown-header {
		font-size: 16px;
		font-weight: 600;
    padding: 15px 10px 10px;
	}
	.sidebar.sidebar-lg .dropdown-menu .dropdown-header:first-child {
		padding-top: 0px;	
	}
	.sidebar.sidebar-lg .dropdown-menu .divider {
		display: none;	
	}
	.sidebar.sidebar-lg .dropdown-menu li a {
		position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
	}
	.sidebar.sidebar-lg .dropdown-menu li a:focus, 
	.sidebar.sidebar-lg .dropdown-menu li a:hover {
    color: #555;
    text-decoration: none;
    background-color: #f5f5f5;
	}
	.sidebar.sidebar-lg .dropdown-menu li a:focus, 
	.sidebar.sidebar-lg .dropdown-menu li a:hover {
    color: #555;
    text-decoration: none;
    background-color: #f5f5f5;
	}
	.sidebar.sidebar-lg .dropdown-menu li.active a, 
	.sidebar.sidebar-lg .dropdown-menu li.active a:focus, 
	.sidebar.sidebar-lg .dropdown-menu li.active a:hover {
    z-index: 2;
    color: #fff;
    background-color: #337ab7;
    border-color: #337ab7;
	}
}
</style>