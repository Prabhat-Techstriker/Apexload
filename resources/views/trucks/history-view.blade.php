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
        <div class="container">
                
          <table class="table">
            <thead>
              <tr>
                <th>KEY</th>
                <th>VALUE</th>
              </tr>
            </thead>
            <tbody>
                @if (isset($newResult->vehicle_detail))
              <tr>
                <td><strong>Origin</strong></td>
                <td>{{isset($newResult->vehicle_detail->orign_name) ? $newResult->vehicle_detail->orign_name : ''}}</td>
              </tr>
              <tr>
                <td><strong>Destination<strong></td>
                <td>{{isset($newResult->vehicle_detail->destination_name) ? $newResult->vehicle_detail->destination_name : ''}}</td>
              </tr>
              <tr>
                <td><strong>Load<strong></td>
                <td>{{isset($newResult->vehicle_detail->load_size) ? $newResult->vehicle_detail->load_size : ''}}</td>
              </tr>
              <tr>
                <td><strong>Search Redius<strong></td>
                <td>{{isset($newResult->vehicle_detail->miles) ? $newResult->vehicle_detail->miles : ''}}</td>
              </tr>
              <tr>
                <td><strong>Length(m)<strong></td>
                <td>{{isset($newResult->vehicle_detail->lenght) ? $newResult->vehicle_detail->lenght : ''}}</td>
              </tr>
              <tr>
                <td><strong>Height(m)<strong></td>
                <td>{{isset($newResult->vehicle_detail->hieght) ? $newResult->vehicle_detail->hieght : ''}}</td>
              </tr>
              <tr>
                <td><strong>Width(m)<strong></td>
                <td>{{isset($newResult->vehicle_detail->width) ? $newResult->vehicle_detail->width : ''}}</td>
              </tr>
              <tr>
                <td><strong>Available From<strong></td>
                <td>{{isset($newResult->vehicle_detail->available_date_from) ? $newResult->vehicle_detail->available_date_from : ''}}</td>
              </tr>
              <tr>
                <td><strong>Available Until<strong></td>
                <td>{{isset($newResult->vehicle_detail->available_date_to) ? $newResult->vehicle_detail->available_date_to : ''}}</td>
              </tr>
              @else
                <tr>
                  <td><strong>Origin<strong></td>
                  <td>{{isset($newResult->job_detail->orign_name) ? $newResult->job_detail->orign_name : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Destination<strong></td>
                  <td>{{isset($newResult->job_detail->destination_name) ? $newResult->job_detail->destination_name : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Equipment Type<strong></td>
                  <td>{{isset($newResult->job_detail->equipment) ? $newResult->job_detail->equipment : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Load<strong></td>
                  <td>{{isset($newResult->job_detail->load) ? $newResult->job_detail->load : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Search Redius<strong></td>
                  <td>{{isset($newResult->job_detail->miles) ? $newResult->job_detail->miles : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Pieces<strong></td>
                  <td>{{isset($newResult->job_detail->pieces) ? $newResult->job_detail->pieces : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Weight(lbs)<strong></td>
                  <td>{{isset($newResult->job_detail->weight) ? $newResult->job_detail->weight : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Length(m)<strong></td>
                  <td>{{isset($newResult->job_detail->lenght) ? $newResult->job_detail->lenght : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Height(m)<strong></td>
                  <td>{{isset($newResult->job_detail->hieght) ? $newResult->job_detail->hieght : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Width(m)<strong></td>
                  <td>{{isset($newResult->job_detail->width) ? $newResult->job_detail->width : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Company Email<strong></td>
                  <td>{{isset($newResult->job_detail->com_email) ? $newResult->job_detail->com_email : ''}}</td>
                </tr>
                  <tr>
                  <td><strong>Company Name<strong></td>
                  <td>{{isset($newResult->job_detail->com_name) ? $newResult->job_detail->com_name : ''}}</td>
                </tr>
                <tr>
                  <td><strong>Company Phone<strong></td>
                  <td>{{isset($newResult->job_detail->com_phone) ? $newResult->job_detail->com_phone : ''}}</td>
                </tr>
                <tr>
                  <td><strong>User<strong></td>
                  <td>{{isset($user->first_name) ? $user->first_name : ''}} {{isset($user->last_name) ? $user->last_name : ''}}</td>
                </tr>
                <tr>
                  <td><strong>user Phone<strong></td>
                  <td>{{isset($user->phone_number) ? $user->phone_number : ''}}</td>
                </tr>
                <tr>
                  <td><strong>User Email<strong></td>
                  <td>{{isset($user->email) ? $user->email : ''}}</td>
                </tr>
              @endif
            </tbody>
          </table>
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