<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.dashborad") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('users_manage')
                <!-- <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    </ul>
                </li> -->
                
                <li class="nav-item">
                    <a href="{{ route('admin.shippers') }}" class="nav-link">
                        <i class="fa-fw fas fa-users nav-icon"></i>
                        Shipper List
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.post-loasds.index') }}" class="nav-link">
                        <i class="fa-fw fas fa-users nav-icon"></i>
                        All Post Loads
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.drivers') }}" class="nav-link">
                        <i class="fa-fw fas fa-users nav-icon"></i>
                        Driver List
                    </a>
                </li>

                 <li class="nav-item">
                    <a href="{{ route('admin.trucks.index') }}" class="nav-link">
                        <i class="fa-fw fas fa-truck nav-icon"></i>
                        All Trucks Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.responsibility') }}" class="nav-link">
                        <i class="fa-fw fas fa-user nav-icon"></i>
                        Responsibility Type
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="nav-link">
                        <i class="fa-fw fas fa-truck nav-icon"></i>
                        Truck Brands
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.equipments.index') }}" class="nav-link">
                        <i class="fa-fw fas fa-cog nav-icon"></i>
                        Equipments Type
                    </a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-envelope nav-icon"></i>
                       Contacts Data
                    </a>
                     <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts') }}" class="nav-link">
                                <i class="fa-fw fas fa-envelope nav-icon">

                                </i>
                                Contact Form
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.newslatters') }}" class="nav-link ">
                                <i class="fa-fw fas fa-envelope nav-icon">

                                </i>
                                Newslatter
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logoslider') }}" class="nav-link">
                        <i class="fa-fw fas fa-sliders nav-icon"></i>
                        Logo Slider
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link">
                        <i class="fa-fw fas fa-sliders nav-icon"></i>
                        Testimonials
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('auth.change_password') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-key">

                    </i>
                    Change password
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>