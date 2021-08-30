@extends('layouts.webloging')
@section('content') 
<header class="page_header contact_header">
<h1>Edit Vechile</h1>
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
        <div class="search_form post_truck_form">
            <div class="container">
                <form method="get" action="" id="post_truck_edit" name="post_truck">
                    <div class="row">
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label for=""><i class="text-danger fas fa-map-marker-alt"></i>Select Origin Location</label>
                                <input type="text" name="search_input1" id="search_input1" class="form-control" placeholder="Choose Location" value="{{$vehiclePost->orign_name}}">
                                <input type="hidden" name="orign_name" id="orign_name" value="{{$vehiclePost->orign_name}}">
                                <input type="hidden" name="orign_lat" id="orign_lat" value="{{$vehiclePost->orign_lat}}">
                                <input type="hidden" name="orign_long" id="orign_long" value="{{$vehiclePost->orign_long}}">
                                <input type="hidden" name="post_id" value="{{$vehiclePost->id}}">
                                <input type="hidden" name="miles" value="{{$vehiclePost->miles}}">
                            </div>

                            <div class="form-group truck_brand">
                                <label for=""><img  class="gray_scale" src="{{ URL::to('/') }}/public/images/delivery_icon.png" alt="Icon" /></label>
                                <select name="vehicle_brand" id="vehicle_brand" class="form-control">
                                    <option >Brand Name</option>
                                    @foreach ($VehicleBrand as $vehicle_Brand)
                                        <option value="{{$vehicle_Brand->brand_name}}" {{($vehicle_Brand->brand_name === $vehiclePost->vehicle_brand) ? 'selected' : ''}}>{{$vehicle_Brand->brand_name}}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                                
                            <div class="form-group">
                                <label for=""><i class="fas fa-truck"></i>Truck Size</label>
                                <div class="truck_size">
                                    <div class="truck_props">
                                        <div class="help_text">Length</div>
                                        <input type="number" class="form-control" name="lenght" id="lenght" value="{{$vehiclePost->lenght}}"/>
                                    </div>
                                    <div class="truck_props">
                                        <div class="help_text">Height</div>
                                        <input type="number" class="form-control" name="hieght" id="hieght" value="{{$vehiclePost->hieght}}"/>
                                    </div>
                                    <div class="truck_props">
                                        <div class="help_text">Width</div>
                                        <input type="number" class="form-control" name="width" id="width" value="{{$vehiclePost->width}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">                            
                            <div class="form-group">
                                <label for=""><i class="text-success fas fa-map-marker-alt"></i>Select Destination Location</label>
                                <input type="text" name="search_input2" id="search_input2" class="form-control" placeholder="Choose Location" value="{{$vehiclePost->destination_name}}">
                                <input type="hidden" name="destination_name" id="destination_name" value="{{$vehiclePost->destination_name}}">
                                <input type="hidden" name="destination_lat" id="destination_lat" value="{{$vehiclePost->destination_lat}}">
                                <input type="hidden" name="destination_long" id="destination_long" value="{{$vehiclePost->destination_long}}">
                            </div>   

                            <div class="form-group">
                                <label for=""><i class="fas fa-calendar-alt"></i>Available date</label>
                                <div id="" class="input-group date" data-date-format="mm/dd/yyyy">
                                    <input id="available_date_from" name="available_date_from" class="form-control" type="text" placeholder="Anytime" readonly  value="{{$vehiclePost->available_date_from}}"/>
                                    <span class="input-group-addon"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for=""><i class="fas fa-cube"></i>Load Size</label>
                                <select name="load_size" id="load_size" class="form-control js-select2">
                                  <option>Any</option>
                                  <option value="TL" {{($vehiclePost->load_size === "TL") ? 'selected' : ''}}>TL</option>
                                  <option value="LTL" {{($vehiclePost->load_size === "LTL") ? 'selected' : ''}}>LTL</option>
                                  <option value="Intermodal" {{($vehiclePost->load_size === "Intermodal") ? 'selected' : ''}}>Intermodal</option>
                                  <option value="Partial" {{($vehiclePost->load_size === "Partial") ? 'selected' : ''}}>Partial</option>
                                  <option value="Parcel" {{($vehiclePost->load_size === "Parcel") ? 'selected' : ''}}>Parcel</option>
                                  <option value="Drayage" {{($vehiclePost->load_size === "Drayage") ? 'selected' : ''}}>Drayage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">
                                    <img  class="gray_scale" src="{{ URL::to('/') }}/public/images/truck_icon.png" alt="Icon" />Equipment Type
                                </label>
                                </br>
                                @foreach ($equipments as $equipmentsValue)
                                    <input type="checkbox" name="equipment[]" value="{{$equipmentsValue->id}}" @if(in_array($equipmentsValue->id, $vehiclePost->equipment))
                                              checked="checked"
                                            @endif
                                            >&nbsp{{$equipmentsValue->type}}&nbsp&nbsp
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Description">{{$vehiclePost->description}}</textarea>
                        </div>
                        <div class="col-lg-12 text-center">
                            <input type="submit" class="btn submit_btn" value="Search" id="submit" />
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