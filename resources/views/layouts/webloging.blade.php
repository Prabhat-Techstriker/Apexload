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
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
    <!-- <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/custom.css') }}">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4"></script>

    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-firestore.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.20/sweetalert2.all.min.js" integrity="sha512-LQTHxCMBTyQqw1exya4NgYQ7yf4k88KusIUXqfd8+R9fQtlBwdJ15BivuxjfduNsk2tdLGmNKaN2lk5fTQtK3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.20/sweetalert2.min.js" integrity="sha512-KIRtgwO59gNBBB6xsSD53HJ2zXW0PV9aRw4cIR33lTreCLhsjA3RgUwPAWOAYjZ+70olt9+jEdSayO3kNyamVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.20/sweetalert2.min.css" integrity="sha512-rogivVAav89vN+wNObUwbrX9xIA8SxJBWMFu7jsHNlvo+fGevr0vACvMN+9Cog3LAQVFPlQPWEOYn8iGjBA71w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script type="text/javascript">
      // Your web app's Firebase configuration
      // var firebaseConfig = {
      //   apiKey: "",
      //   authDomain: "",
      //   databaseURL: "",
      //   projectId: "",
      //   storageBucket: "",
      //   messagingSenderId: "",
      //   appId: ""
      // };

      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      var firebaseConfig = {
        apiKey: "AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4",
        authDomain: "appexload.firebaseapp.com",

        projectId: "appexload",
        storageBucket: "appexload.appspot.com",
        messagingSenderId: "1033095337139",
        appId: "1:1033095337139:web:3047199d1136843f4b8cc6",
        measurementId: "G-S3TZH9EKM9"
      };

      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      firebase.analytics();
      var database = firebase.firestore();

      //const messaging = firebase.messaging();
    </script>
    
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
    
    @yield('content')
        
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
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/public/js/select2.full.js') }}"></script>
    <script src="{{ asset('/public/js/bootstrap-datepicker.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>   
    <script src="{{ asset('/public/js/custom.js') }}"></script>
    
     @yield('scripts') 
  </body>
</html>