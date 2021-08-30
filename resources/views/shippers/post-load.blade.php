@extends('layouts.webloging')
@section('content') 
<header class="page_header contact_header">
<h1>Post Load</h1>
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
        <div class="search_form post_load_form">
        <div class="container">
            <form method="get" action="" id="post_load" name="post_load">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""><i class="text-danger fas fa-map-marker-alt"></i>Select Origin Location</label>
                            <input type="text" name="search_input1" id="search_input1" class="form-control" placeholder="Choose Location">
                            <input type="hidden" name="orign_name" id="orign_name" value="">
                            <input type="hidden" name="orign_lat" id="orign_lat" value="">
                            <input type="hidden" name="orign_long" id="orign_long" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""><i class="text-success fas fa-map-marker-alt"></i>Select Destination Location</label>
                            <input type="text" name="search_input2" id="search_input2" class="form-control" placeholder="Choose Location">
                            <input type="hidden" name="destination_name" id="destination_name" value="">
                            <input type="hidden" name="destination_lat" id="destination_lat" value="">
                            <input type="hidden" name="destination_long" id="destination_long" value="">
                        </div>                      
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="load_details_box">
                            <div class="load_detail">
                                <span>Pickup Date</span>
                                <input type="text" name="pickup_date" class="date" value="" autocomplete="off">
                            </div>
                            <div class="load_detail">
                                <span>Equipment type</span>
                                @foreach ($equipments as $equipmentsValue)
                                    <label><input type="checkbox" name="equipment[]"  value="{{$equipmentsValue->id}}">{{$equipmentsValue->type}}</label>
                                @endforeach
                            </div>
                            <div class="load_detail">
                                <span>Load</span>
                                <input type="text" name="load">
                            </div>
                            <div class="load_detail">
                                <span>Weight(Ibs)</span>
                                <input type="text" name="weight">        
                            </div>
                            <div class="load_detail">
                                <span>Length(ft)</span>
                                <input type="text" name="lenght">
                            </div>
                            <div class="load_detail">
                                <span>Height(ft)</span>
                                <input type="text" name="hieght">
                            </div>
                            <div class="load_detail">
                                <span>Width(ft)</span>
                                <input type="text" name="width">
                            </div>
                            <div class="load_detail">
                                <span>Pieces</span>
                                <input type="text" name="pieces">
                            </div>
                            <div class="load_detail">
                                <span>Quantity</span>
                                <input type="text" name="quantity">
                            </div>
                            <div class="load_detail">
                                <span>Set Price(USD)</span>
                                <input type="text" name="set_price">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <button class="btn btn-link btn-block collapsed text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Company Detail
                                    </button>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
       
                                    <div class="load_details_box">
                                        <div class="load_detail">
                                            <span>Name</span>
                                            <input type="text" name="com_name">
                                        </div>
                                        <div class="load_detail">
                                            <span>Contact</span>
                                            <input type="text" name="com_phone">
                                        </div>
                                        <div class="load_detail">
                                            <span>Email</span>
                                            <input type="text" name="com_email">
                                        </div>
                                        <div class="load_detail">
                                            <span>Office</span>
                                            <input type="text" name="com_office">
                                        </div>
                                        <div class="load_detail">
                                            <span>Fax</span>
                                            <input type="text" name="com_fax">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <button class="btn btn-link btn-block collapsed text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Personal Information
                                    </button>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="load_details_box">
                                        <div class="load_detail">
                                            <span>User</span>
                                            <input type="text" name="com_name" value="{{$user->first_name}} {{$user->last_name}}" readonly>
                                        </div>
                                        <div class="load_detail">
                                            <span>Phone</span>
                                            <input type="text" name="com_phone" value="{{$user->phone_number}}" readonly>
                                        </div>
                                        <div class="load_detail">
                                            <span>Email</span>
                                            <input type="text" name="com_email" value="{{$user->email}}" readonly>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <input type="submit" class="btn submit_btn" value="Submit" id="submit" />
                    </div>
                </div>  
            </form>
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