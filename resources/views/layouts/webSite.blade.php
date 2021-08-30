<!DOCTYPE html>
<html>
<head>

 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME', 'Apexloads') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/public/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/custom.css') }}">

    @yield('styles')
</head>

    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    Call: <a href="">0123456789</a> Email: <a href="mailto:info@apexloads.com">info@apexloads.com</a>
                </div>  
                <div class="col-md-6">
                    <div class="right_side">    
                        @guest
                            <span><i class="fas fa-user-plus"></i><a href="#singup" class="trigger-btn singotp" data-toggle="modal">Sing Up</a></span>
                            <span class="divider"></span>
                            <span><i class="fas fa-user"></i> <a href="#login" class="trigger-btn" data-toggle="modal">Login</a></span>
                        @endguest
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>

                            </form>
                        @endauth
                         
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg ">
      <div class="container">   
        <a class="navbar-brand" href="{{ url('index') }}"><img src="{{ asset('/public/images/logo.jpg') }}" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Carriers
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Action</a>
            </div>
          </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Brokers
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Action</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Shippers
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Action</a>
            </div>
          </li>
          <li class="nav-item prc_btn">
            <a class="nav-link" href="#">Pricing</a>
          </li>
        </ul>
      </div>
      </div>
    </nav>
    
    @yield('content')

        
    <footer>
        <div class="footer_outer">
            <div class="left_side">
                <a href="{{ url('index') }}"><img src="{{ asset('/public/images/logo.jpg') }}" alt="Logo" /></a>
            </div>
            <div class="right_side">
                <div class="footer_col">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="{{ url('about-us') }}">About Us</a></li>
                        <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                        <li><a href="">Newsletter</a></li>
                        <li><a href="">Pricing</a></li>
                    </ul>
                </div>
                <div class="footer_col">
                    <h4>Carriers</h4>
                    <ul>
                        <li><a href="search_loads.html">Search for loads</a></li>
                        <li><a href="post_truck.html">Post trucks</a></li>
                    </ul>
                </div>
                <div class="footer_col">
                    <h4>Brokers</h4>
                    <ul>
                        <li><a href="post_load.html">Post loads</a></li>
                        <li><a href="search_trucks.html">Search for trucks</a></li>
                    </ul>
                </div>
                <div class="footer_col">
                    <h4>Shippers</h4>
                    <ul>
                        <li><a href="post_load.html">Post loads</a></li>
                        <li><a href="search_trucks.html">Search for trucks</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    <div class="footer_bottom">
        <div class="footer_outer">
            <p>&copy; 2021 Apexloads. All rights reserved.</p>
            <div class="social_icons">
                <a href="">
                    <i class="fab fa-facebook-square"></i>
                </a>    
                <a href="">
                    <i class="fab fa-instagram"></i>
                </a>    
                <a href="">
                    <i class="fab fa-twitter"></i>
                </a>    
                <a href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>    
            </div>
        </div>
    </div>     
    @include('popups.reglogin')
    <script src="{{ asset('/public/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/public/js/owl.carousel.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>   
    <script src="{{ asset('/public/js/custom.js') }}"></script>   
     @yield('scripts') 
  </body>
</html>