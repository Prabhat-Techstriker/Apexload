<!-- Modal HTML -->
<div id="login" class="modal fade">
    <div class="modal-dialog modal-login modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">              
                <h4 class="modal-title">Login</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" onsubmit="return LoginUser()" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="log_username"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus value="{{ old('email', null) }}" placeholder="Email or Phone" required="required">
                    </div>
                    <div class="form-group">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="log_password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Password" required="required">                 
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-4 pleasewait">Login</button>
                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#singup" class="trigger-btn" data-toggle="modal">Sing Up</a> | <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>  


<div id="singup" class="modal fade">
    <div class="modal-dialog modal-login modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">              
                <h4 class="modal-title">Sing Up</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" onsubmit="return signup()" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="sing_username"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', null) }}" placeholder="Email or Phone" required="required">
                    </div>
                    <div class="form-group">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="sing_password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Password" minlength="6" required="required">                 
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-4 pleasewait">Submit</button>
                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#login" class="trigger-btn" data-toggle="modal">Login</a> | <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>
</div> 

<div id="enterOtp" class="modal fade">
    <div class="modal-dialog modal-login modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">              
                <h4 class="modal-title">Enter OTP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" onsubmit="return enterOtpbyemail()" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div id="divOuter">
                          <div id="divInner">
                        <input id="activation_token" type="text" name="activation_token" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onKeyPress="if(this.value.length==6) return false;"/>
                          </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-4 pleasewait">Submit</button>
                       
                    </div>
                     <a href="javascript:void(0);" class="trigger-btn" id="myuserenter" data="" onclick="return reSendotp()" >Resend Otp</a>
                </form>
            </div>
            
        </div>
    </div>
</div>

<div id="enterOtpwithphone" class="modal fade">
    <div class="modal-dialog modal-login modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">              
                <h4 class="modal-title">Enter OTP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" onsubmit="return enterOtpByphone()" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div id="divOuter">
                          <div id="divInner">
                        <input id="partitioned" type="text" name="verification_code" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onKeyPress="if(this.value.length==6) return false;"/>
                          </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-4 pleasewait">Submit</button>
                       
                    </div>
                     <a href="javascript:void(0);" class="trigger-btn" id="myuserenterphone" data="" onclick="return reSendotp()" >Resend Otp</a>
                </form>
            </div>
            
        </div>
    </div>
</div>

<style>
#activation_token ,#partitioned {
    padding-left: 10px;
    letter-spacing: 41px;
    border: 0;
    background-image: linear-gradient(to left, black 60%, rgba(255, 255, 255, 0) 0%);
    background-position: bottom;
    background-size: 50px 1px;
    background-repeat: repeat-x;
    background-position-x: 29px;
    width: 100%;
    min-width: 100%;
}

#divInner{
  left: 0;
  position: sticky;
}

#divOuter {
    width: 100%;
}
</style>