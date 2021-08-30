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
            <div class="col-lg-12 text-right">
                <a href="{{url('web/post-load')}}">
                    <button type="button" class="btn btn-success">Add Post Load</button>
                </a>
            </div>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <!-- <th>Posted By</th> -->
                    <th>Orign Name</th>
                    <th>Destination Name</th>
                    <th>Miles</th>
                    <th>Pickup Date</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($postloads as $postloads)
                <tr>
                    <!-- <td>{{isset($user->first_name) ? $user->first_name : ''}}</td> -->
                    <td>{{isset($postloads->orign_name) ? $postloads->orign_name : ''}}</td>
                    <td>{{isset($postloads->destination_name) ? $postloads->destination_name : ''}}</td>
                    <td>{{isset($postloads->miles) ? $postloads->miles : ''}}</td>                
                    <td>{{$postloads->pickup_date}}</td>
                    <td>{{isset($postloads->set_price) ? $postloads->set_price : ''}}</td>
                    <td>{{isset($postloads->status) == 1 ? "Active" : ''}}</td>
                    <!-- <td class="change_status_{{$user->id}}"><a id="{{$postloads->id}}" href="javascript:" onclick="delete_user(this.id)" data-id="{{$user->id}}"><i class="far fa-edit-alt"></i></a></td> -->
                    <td class="change_status_{{$user->id}}">
                        <a id="{{$postloads->id}}" href="{{url('web/post-load-edit')}}/{{$postloads->id}}" data-id="{{$postloads->id}}"><i class="far fa-edit"></i></a>&nbsp
                        <a id="{{$postloads->id}}" href="javascript:" onclick="delete_data('{{$postloads->id}}','post-load-delete')" data-id="{{$postloads->id}}"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                 @endforeach
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