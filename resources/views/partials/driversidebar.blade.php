<div class="dropdown sidebar sidebar-md">
	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		<li class=""><a href="{{ url('/web/user-dashboard') }}" class="{{ Request::url() == url('web/user-dashboard') ? 'active-menu' : '' }}">Dashboards</a></li>
		<!-- <li class=""><a href="{{ url('/myprofile') }}/web/user-dashboard">My Profile</a></li> -->
		<li><a href="{{url('web/getPostAllrequests')}}" class="{{ Request::url() == url('web/getPostAllrequests') ? 'active-menu' : '' }}" ?>My Request</a></li>
		<li><a href="{{url('web/vehicle-list')}}" class="{{ Request::url() == url('web/vehicle-list') ? 'active-menu' : '' }}" >My Trucks</a></li>
		<li><a href="{{ url('web/complete-job') }}" class="{{ Request::url() == url('web/complete-job') ? 'active-menu' : '' }}" >History</a></li>
		<li><a href="{{ url('web/setting') }}" class="{{ Request::url() == url('web/setting') ? 'active-menu' : '' }}" >Setting</a></li>
	</ul>
</div>