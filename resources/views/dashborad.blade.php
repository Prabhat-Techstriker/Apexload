@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
        	<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <!-- <h1 class="mt-4">Dashboard</h1> -->
                        
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <h2 class="warning">Post Loads</h2>
                                    <div class="counter-box colored"> <i class="fa fa-users" aria-hidden="true"></i> <span class="counter">{{count($newPostloads)}}</span>
						                <p>Active Post Loads</p>
						            </div>
                                    <ul class="sent">
                                        
                                        @foreach ($newPostloads as $postload)
                                    	   <li>Posted By: {{$postload->poste_by ?? 'N.A'}} <span>{{ date('d M Y', strtotime($postload->created_at)) }}</span></li>
                                    	@endforeach
                                    </ul>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="stretched-link" href="{{ route("admin.post-loasds.index") }}">View More</a>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <h2 class="info">Trucks Post</h2>
                                    <div class="counter-box colored mycontacts"> <i class="fa fa-truck" aria-hidden="true"></i> <span class="counter">{{count($newTruckspost)}}</span>
						                <p>Active Truck Posts</p>
						            </div>
                                    <ul class="completed sent">
                                    	 @foreach ($newTruckspost as $truck)
                                           <li>Posted By: {{$truck->poste_by ?? 'N.A'}} <span>{{ date('d M Y', strtotime($truck->created_at)) }}</span></li>
                                        @endforeach
                                    </ul>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class=" stretched-link" href="{{ route("admin.trucks.index") }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
						            <div class="card-content">
						            	<h2 class="info">My Profile</h2>
						                <div class="card-body p-0">
						                    <div class="profile"> 
                                                @if(!empty($users->profile_image) !='') 
                                                    <img id="profileDisplay" src="{{ url('/') }}/storage/app/{{ $users->profile_image}}">
                                                @else
                                                    <img id="profileDisplay" src="{{ url('storage/app/images') }}/avatar-dummy.png">      
                                                @endif
                                            </div>
						                    <div class="card-title"> <strong>Name: </strong> {{ $users->name }} <br/> <strong> Email: </strong>{{ $users->email }} </div> </div>
                                            <div class="card-subtitle">
                                                <p class="text-muted"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                            </div>
						                </div>
						            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
<style>
.profile img {
    width: 250px;
    height: 250px;
    border-radius: 50%;
}
.profile {
    padding: 18px 0px 50px 0px;
}

.card {
    border-radius: 15px;
    margin-left: 30px;
    margin-right: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, .2)
}

.card-body {
    position: relative;
        text-align: center;

}
p.text-muted {
    padding: 30px 50px 30px 50px;
    text-align: center;
}
.card-footer {
    padding: 0.70rem 1.25rem;
    background-color: unset;
    border: 1px solid rgba(0,0,0,0.125);
    margin: 0 auto;
    margin-bottom: 15px;
}
a.stretched-link {
    position: unset;
}
.stretched-link::after {
    position: unset;
}
h2.success {
    font-size: 22px;
    /*background: #076b07;*/
    color: #000;
    text-align: center;
    padding: 13px;
}
h2.info {
    font-size: 22px;
    /*background: #63c2de;*/
    color: #000;
    text-align: center;
    padding: 13px;
}
h2.warning {
    font-size: 22px;
    /*background: #ffc107;*/
    color: #000;
    text-align: center;
    padding: 13px;
}
ul.sent li, ul.completed li {
    padding: 4.5px;
}
ul.sent {
    list-style-type: none;
    padding: 10px 20px;
    margin: 0;
}

.sent li {
    border-bottom: 1px dashed #ddd;
    padding: 12px 0px !important;
    display: inline-block;
    width: 100%;
    position: relative;
}

.sent li i {
    margin-right: 8px;
}

.sent li::before {content: "\f00c";font-family: FontAwesome;font-size: 15px;margin-right: 11px;font-weight: 300;}

.sent li span {
    float: right;
    font-style: italic;
    font-size: 13px;
}
.card {
    padding-top: 25px;
}


/*new*/
.counter-box {
    display: block;
    background: #f6f6f6;
    padding: 40px 20px 37px;
    text-align: center
}

.counter-box p {
    margin: 5px 0 0;
    padding: 0;
    color: #909090;
    font-size: 16px;
    font-weight: 500
}

.counter-box i {
    font-size: 50px;
    margin: 0 0 15px;
    color: #d2d2d2;
    font-family: 'FontAwesome';
}

.counter {
    display: block;
    font-size: 30px;
    font-weight: 700;
    color: #666;
    line-height: 28px
}

.counter-box.colored {
    background: #3acf87
}

.counter-box.colored p,
.counter-box.colored i,
.counter-box.colored .counter {
    color: #fff
}
.counter-box.colored {
    width: 220px;
    border-radius: 50%;
    margin: 0 auto;
    padding: 40px;
    height: 220px;
}
.counter-box.colored.mycontacts {
    background: #20a8d8;
}
</style>

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {

$('.counter').each(function () {
$(this).prop('Counter',0).animate({
Counter: $(this).text()
}, {
duration: 4000,
easing: 'swing',
step: function (now) {
$(this).text(Math.ceil(now));
}
});
});

});
</script>
@parent

@endsection