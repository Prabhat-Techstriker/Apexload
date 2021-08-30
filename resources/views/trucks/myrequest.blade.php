@extends('layouts.webloging')
@section('content') 
<header class="page_header contact_header">
<h1>My REQUESTS</h1>
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
            <!-- <div class="col-lg-12 text-right">
                <a href="{{url('web/post-load')}}">
                    <button type="button" class="btn btn-success">Add Post Load</button>
                </a>
            </div> -->
            <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <!-- <th>Posted By</th> -->
                    <th>Orign</th>
                    <th>Destination</th>
                    <th>Approved Status</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($finalResult as $myrequestData){
                    $i = 0;
                    //print_r($myrequestData[$i]);
                    if(isset($myrequestData[$i]['trucks'])){
                ?>
                <tr>
                    <td>{{isset($myrequestData[$i]['trucks']['orign_name']) ? $myrequestData[$i]['trucks']['orign_name'] : ''}}</td>
                    <td>{{isset($myrequestData[$i]['trucks']['destination_name']) ? $myrequestData[$i]['trucks']['destination_name'] : ''}}</td>
                        <!-- <td>{{isset($myrequestData[$i]['trucks']['pickup_date']) ? $myrequestData[$i]['trucks']['pickup_date'] : ''}}</td> -->
                        @if ($myrequestData[$i]['approved'] == 1)
                            <td><a href="javascript:" onclick="accept_request('{{$myrequestData[$i]['id']}}')" class="badge badge-primary">Accept</a></td>
                        @elseif($myrequestData[$i]['approved'] == 2)
                            <!-- <td>Waiting to be hired</td> -->
                            <td><a href="{{url('web/discussion')}}/{{$myrequestData[$i]['requested_by']}}/{{$myrequestData[$i]['posted_by']}}/{{$myrequestData[$i]['id']}}" class="badge badge-secondary">Waiting to be hired</a></td>
                        @else
                            <td>Hired</td>
                        @endif
                        
                        @if ($myrequestData[$i]['status'] == 0)
                            <td>Pending</td>
                        @elseif($myrequestData[$i]['status'] == 1)
                            <td>Start Ride</td>
                        @else
                            <td>Completed</td>
                        @endif
                    <!-- <td class="change_status_{{$user->id}}">
                        <a id="{{$myrequestData[$i]['id']}}" href="{{url('web/history-view')}}/{{$myrequestData[$i]['id']}}" data-id="{{$myrequestData[$i]['id']}}"><i class="far fa-eye"></i></a>&nbsp
                    </td> -->
                </tr>
                <?php
                }elseif(isset($myrequestData[$i]['jobs'])){
                    
                ?>
                <tr>
                    <td>{{isset($myrequestData[$i]['jobs']['orign_name']) ? $myrequestData[$i]['jobs']['orign_name'] : ''}}</td>
                    <td>{{isset($myrequestData[$i]['jobs']['destination_name']) ? $myrequestData[$i]['jobs']['destination_name'] : ''}}</td>
                        <!-- <td>{{isset($myrequestData[$i]['trucks']['pickup_date']) ? $myrequestData[$i]['trucks']['pickup_date'] : ''}}</td> -->
                        <!-- @if ($myrequestData[$i]['approved'] == 1)
                            <td>Pending</td>
                        @elseif($myrequestData[$i]['approved'] == 2)
                            <td>Accepted</td>
                        @else
                            <td>Hired</td>
                        @endif
                        
                        @if ($myrequestData[$i]['status'] == 0)
                            <td>Pending</td>
                        @elseif($myrequestData[$i]['status'] == 1)
                            <td>Start Ride</td>
                        @else
                            <td>Completed</td>
                        @endif -->
                        @if ($myrequestData[$i]['approved'] == 1)
                            <td>Pending</td>
                        @elseif($myrequestData[$i]['approved'] == 2)
                            
                            <!-- <td><a href="javascript:" onclick="hire_request('{{$myrequestData[$i]['id']}}')" class="badge badge-primary">Hire</a></td> -->
                            <td><a href="{{url('web/discussion')}}/{{$myrequestData[$i]['requested_by']}}/{{$myrequestData[$i]['posted_by']}}/{{$myrequestData[$i]['id']}}" class="badge badge-success">Accepted</a></td>
                        @else
                            <td>Hired</td>
                        @endif
                        
                        @if ($myrequestData[$i]['status'] == 0)
                            <td>Pending</td>
                        @elseif($myrequestData[$i]['status'] == 1)
                            <td>Start Ride</td>
                        @else
                            <td>Completed</td>
                        @endif
                    <!-- <td class="change_status_{{$user->id}}">
                        <a id="{{$myrequestData[$i]['id']}}" href="{{url('web/history-view')}}/{{$myrequestData[$i]['id']}}" data-id="{{$myrequestData[$i]['id']}}"><i class="far fa-eye"></i></a>&nbsp
                    </td> -->
                </tr>
                <?php
                }
                    $i++;
                }
                ?>
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