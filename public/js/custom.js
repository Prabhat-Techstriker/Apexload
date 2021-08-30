$('.testimonials-carousel').owlCarousel({
	loop:true,
	nav: true,
	dots: false,
	autoplay:true,
	autoplayTimeout:3000,
	autoplayHoverPause:false,
	margin:10,
	navText : ["<i class='fas fa-arrow-left'></i>","<i class='fas fa-arrow-right'></i>"],
	responsiveClass:true,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:1
		},
		1000:{
			items:1
		}
	}
});

$('.brands-carousel').owlCarousel({
	loop:true,
	nav: true,
	dots: false,
	autoplay:true,
	autoplayTimeout:3000,
	autoplayHoverPause:false,
	margin:10,
	navText : ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
	responsiveClass:true,
	responsive:{
		0:{
			items:2
		},
		600:{
			items:3
		},
		1000:{
			items:5
		}
	}
});

// Select 2 dropdown

$(document).ready(function() {
  
  $(".js-select2").select2();
  
  //$(".js-select2-multi").select2();
  
});

// Range Slider

$(window).on("load", function(){ 
    var range = $("#range").attr("value");
	$("#miles_value").html(range);
	$(document).on('input change', '#range', function() {
		$('#miles_value').html( $(this).val() );
	});
});

// Date Picker

$(function () {
  $(".date").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  })
  //.datepicker('update', new Date());
});



//Login page
function LoginUser(){
    var token    = $("input[name=_token]").val();
    var username    = $("input[name=log_username]").val();
    var password = $("input[name=log_password]").val();
    var data = {
        _token:token,
        username:username,
        password:password
    };
    // Ajax Post 
    $(".pleasewait").html('Please wait...');
    $.ajax({
        type: "post",
        url: 'http://112.196.38.115:4154/apexloads/loginWeb',
        data: data,
        cache: false,
        success: function (data)
        {
            console.log(data.user.responsibilty_type);
            toastr.success(data.message);
            if(data.user.responsibilty_type != null && data.user.account_type != null){
                window.location.href = 'http://112.196.38.115:4154/apexloads/web/user-dashboard'; 
            } else{
                window.location.href = 'http://112.196.38.115:4154/apexloads/web/create-profile'; 
            }
            $(".pleasewait").html('Submit');
        },
        error: function (data){
           toastr.error('Invalid username or password!!');
           $(".pleasewait").html('Submit');
        }
    });
    return false;
}

//websiteSignup page
function signup(){

    var token    = $("input[name=_token]").val();
    var username    = $("input[name=sing_username]").val();
    var password = $("input[name=sing_password]").val();
    var datas = {
        _token:token,
        username:username,
        password:password
    };
    $(".pleasewait").html('<i class="fas fa-circle-notch fa-spin"></i>Loading');

    $('#myuserenter').attr('data',username);
    $('#myuserenterphone').attr('data',username);
    // Ajax Post 
    $.ajax({
        type: "post",
        url: 'http://112.196.38.115:4154/apexloads/signup',
        data: datas,
        cache: false,
        dataType: "json",
        success: function (data)
        {
        	if (data.success == true) {
        		toastr.success(data.message);
                if (data.user.phone_number == username) {
                    $('#enterOtpwithphone').modal('show');
                    $('#singup').modal('hide');
                    $('.singotp').attr("href", '#enterOtpwithphone');
                    $(".pleasewait").html('Submit');
                }else{
                    $('#enterOtp').modal('show');
                    $('#singup').modal('hide');
                    $('.singotp').attr("href", '#enterOtp');
                    $(".pleasewait").html('Submit');

                }
                
        	}else {
        		toastr.error(data.message);
                $(".pleasewait").html('Submit');

        	}
        },
        error: function (error){
           toastr.error('This email and mobile is already in use. Please use another one.');
           $(".pleasewait").html('Submit');
        }
    });
    return false;
}


//verify otp on email
function enterOtpbyemail(){

    var token    = $("input[name=_token]").val();
    var activation_token    = $("input[name=activation_token]").val();
    
    var datas = {
        _token:token,
        activation_token:activation_token
    };
    $(".pleasewait").html('Please wait...');
    // Ajax Post 
    $.ajax({
        type: "post",
        url: 'http://112.196.38.115:4154/apexloads/byemailotp',
        data: datas,
        cache: false,
        dataType: "json",
        success: function (data)
        {
            if (data.success == true) {
                toastr.success(data.message);
                $(".pleasewait").html('Submit');
                $('#login').modal('show');
                $('#enterOtp').hide('show');
               // window.location.href = 'http://112.196.38.115:4154/apexloads/web/create-profile'; 
                
            }else {
                toastr.error(data.message);
                $(".pleasewait").html('Submit');

            }
        }
    });
    return false;
}

// resend otp
function reSendotp(){

    var token     =  $("input[name=_token]").val();
    var username  = $('#myuserenter').attr('data');
    var datas = {
        _token:token,
        username:username
    };
    
    // Ajax Post 
    $.ajax({
        type: "post",
        url: 'http://112.196.38.115:4154/apexloads/regenerate-otp',
        data: datas,
        cache: false,
        dataType: "json",
        success: function (data)
        {
            if (data.success == true) {
                toastr.success(data.message);
                
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
           toastr.error('User ' + thrownError);
        }
    });
    return false;
}

//verfiy with phone otp
function enterOtpByphone(){

    var token    = $("input[name=_token]").val();
    var verification_code    = $("input[name=verification_code]").val();
    var phone_number  = $('#myuserenterphone').attr('data');

    var datas = {
        _token:token,
        verification_code:verification_code,
        phone_number:phone_number
    };
    // Ajax Post 
    $.ajax({
        type: "post",
        url: 'http://112.196.38.115:4154/apexloads/loginOtpWithphone',
        data: datas,
        cache: false,
        dataType: "json",
        success: function (data)
        {
            if (data.success == true) {
                toastr.success(data.message);
                $(".pleasewait").html('Submit');
                $('#login').modal('show');
                $('#enterOtpwithphone').modal('hide');
                
            }else {
                toastr.error(data.message);
                $(".pleasewait").html('Submit');


            }
        }
    });
    return false;
}

$(document).ready(function() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });


    $("#select1").change(function() {
      if ($(this).data('options') === undefined) {
        /*Taking an array of all options-2 and kind of embedding it on the select1*/
        $(this).data('options', $('#select2 option').clone());
      }
      var id = $(this).val();
      var options = $(this).data('options').filter('[value=' + id + ']');
      $('#select2').html(options);
    });



});

//change option for re
    $('#responsbilityType').on('change', function() {
        var id = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'http://112.196.38.115:4154/apexloads/admin/get-account-responsibity',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){ 
                if(!Object.keys(response).length){
                    $('#accounttype').prop("disabled", true);
                }   
                else 
                {
                    $('#accounttype').prop("disabled", false);
                    var dropdown = $('#accounttype');
                    dropdown.empty();
                    dropdown.append('<option selected="true" disabled>Choose Account Type</option>');
                    dropdown.prop('selectedIndex', 0);
                    $.each(response, function (key, entry) {
                        dropdown.append($('<option></option>').attr('value', entry.id).text(entry.accounts_type));
                    })
                }
            }
        });
    });


    /*-----------code by prabhat-----------*/

    $('#post_load').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Processing...',
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        });
        var formData = $('#post_load').serialize();
        
        var id = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/jobPost',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(response){ 
                console.log(response);
                if(response.success == true){
                    Swal.close();
                    toastr.success(response.message);
                    /*setInterval(function(){ 
                        window.location.href = window.location.origin+'/apexloads/web/post-load-list';
                    }, 5000);*/
                }   
                else 
                {
                    
                }
            }
        });
    });

    $('#post_load_edit').on('submit', function(e) {
        console.log(window.location.origin);
        e.preventDefault();
        Swal.fire({
            title: 'Processing...',
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        });
        var formData = $('#post_load_edit').serialize();
        
        var id = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/post-load-edit',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(response){ 
                if(response.success == true){
                    Swal.close();
                    toastr.success(response.message);
                    /*setInterval(function(){ 
                        window.location.href = window.location.origin+'/apexloads/web/post-load-list';
                    }, 5000);*/
                }   
                else 
                {
                    
                }
            }
        });
    });


    $('#post_truck').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Processing...',
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        });
        var formData = $('#post_truck').serialize();
        
        var id = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/vehicle-post-add',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(response){ 
                console.log(response);
                if(response.success == true){
                    Swal.close();
                    toastr.success(response.message);
                    /*setInterval(function(){ 
                        window.location.href = window.location.origin+'/apexloads/web/vehicle-list';
                    }, 5000); */                   
                }   
                else 
                {
                    
                }
            }
        });
    });

    $('#post_truck_edit').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Processing...',
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        });
        var formData = $('#post_truck_edit').serialize();
        
        var id = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/vehicle-post-edit',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(response){ 
                console.log("response---------",response);
                if(response.success == true){
                    Swal.close();
                    toastr.success(response.message);
                    /*setInterval(function(){ 
                        window.location.href = window.location.origin+'/apexloads/web/vehicle-list';
                    }, 5000);*/
                }else 
                {
                    console.log("errors");
                }
            },
            error: function(request, status, error){
                data = JSON.parse(request.responseText);
                console.log("errors",data.error.miles[0]);

                var arr = data.error;
                console.log(typeof arr);
                var html = '';
                $.each(arr, function(i, index) {
                    html += '<p>'+index+'</p></br>';
                });

                Swal.fire({
                    icon: 'error',
                    html:html,
                    focusConfirm: false,
                });
            }
        });
    });


/*-----------code by prabhat-----------*/
var searchInput1 = 'search_input1';
var place;
$(document).ready(function () {
 var autocomplete;
 autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput1)), {
  types: ['geocode'],
  /*componentRestrictions: {
   country: "USA"
  }*/
 });
 google.maps.event.addListener(autocomplete, 'place_changed', function () {
  var near_place = autocomplete.getPlace();
  place = near_place.formatted_address;
  getLocation1(place);
  console.log("near_place",near_place);
 });
});

var getLocation1 =  function(address) {
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': address}, function(results, status) {

  if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng();
      $("#orign_name").val(address);
      $("#orign_lat").val(latitude);
      $("#orign_long").val(longitude);
      console.log("---------------->>>>>>>>>>>>>>>>>>>",latitude, longitude);
      } 
  }); 
}


var searchInput2 = 'search_input2';
var place;
$(document).ready(function () {
 var autocomplete;
 autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput2)), {
  types: ['geocode'],
  /*componentRestrictions: {
   country: "USA"
  }*/
 });
 google.maps.event.addListener(autocomplete, 'place_changed', function () {
  var near_place = autocomplete.getPlace();
  place = near_place.formatted_address;
  getLocation2(place);
  console.log("near_place",near_place);
 });
});



var getLocation2 =  function(address) {
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': address}, function(results, status) {

  if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng();
      $("#destination_name").val(address);
      $("#destination_lat").val(latitude);
      $("#destination_long").val(longitude);
      console.log("---------------->>>>>>>>>>>>>>>>>>>",latitude, longitude);
      } 
  }); 
}

$(document).ready(function() {
    $('#example').DataTable();

} );

function delete_data(id,dataparam) {
    console.log(id,dataparam);
    console.log(window.location.origin+'/apexloads/web/'+dataparam+'/'+id);
    //$("#login-User").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/'+dataparam+'/'+id,
            type: 'delete',
            //data: formData,
            dataType:'json',
            success: function (result) {
                location.reload()
            },
            error: function (request, status, error) {
                
            }
        });
    //});
}


function edit_data(id,dataparam) {
    console.log(id,dataparam);
    console.log(window.location.origin+'/apexloads/web/'+dataparam);
    //$("#login-User").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/'+dataparam+'/'+id,
            type: 'delete',
            dataType:'json',
            success: function (result) {
                location.reload()
            },
            error: function (request, status, error) {
                
            }
        });
    //});
}

function accept_request(id) {
    console.log(id);
    //return false;
    //$("#login-User").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/approveRequestWeb',
            type: 'POST',
            data: {booking_id:id},
            dataType:'json',
            success: function (result) {
                console.log(result.success);
                if (result.success == true) {
                    location.reload()
                }else{

                }
                //location.reload()
            },
            error: function (request, status, error) {
                
            }
        });
    //});
}

function hire_request(id) {
    console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/apexloads/web/hiredRequestWeb',
            type: 'POST',
            data: {booking_id:id},
            dataType:'json',
            success: function (result) {
                console.log(result.success);
                if (result.success == true) {
                    location.reload()
                }else{

                }
            },
            error: function (request, status, error) {
                
            }
        });
}


$('#prefrences').on('submit', function(e) {
    e.preventDefault();
    var formData = $('#prefrences').serialize();
    
    var id = this.value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin+'/apexloads/web/saveOriginDestinationWeb',
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function(response){ 
            console.log(response);
            if(response.success == true){
                console.log(response);
                window.location.href = window.location.origin+'/apexloads/web/setting';
            }   
            else 
            {
                
            }
        }
    });
});

$(document).ready(function() {
    setInterval(function(){
        ajaxFunc()
    }, 1000);

    $(".messages").animate({ scrollTop: $(document).height()+1500 }, "fast");

    $('#chatButton').click(function(){
        var msg = $("#chatMessage").val();
        var id1 = $("#id1").val();
        var id2 = $("#id2").val();
        var sender_id = $("#login_id").val();
        var sender_name = $("#sender_name").val();
        var reciver_id = $("#reciver_id").val();
        var token  = $("input[name=_token]").val();
        
        if (msg == '') {
        }else{
            $("#chatMessage").val("");
            $.ajax({
                url: window.location.origin+'/apexloads/web/send-message',
                type:"POST",
                data: {message:msg , sender_id:sender_id , sender_name:sender_name , id1:id1 , id2:id2 , _token:token , reciver_id:reciver_id},
                dataType : "json",
                success:function(response){
                    if (response.success == true) {
                        response = response.chatArray;
                        $('#conversation').html(response);
                        toastr.success("messages sent.");
                    }
                },
           });
        }
    });
});


function ajaxFunc() {
    var url = window.location.href;
    if(url.includes("discussion")){
        var updateUrl = url.replace('discussion', 'discussionAjax');
    
        $.ajax({
        url: updateUrl,
        type:"GET",
        dataType : "json",
        success:function(response){
            response = response.chatArray;
                $('#conversation').html(response);
            },
       });
    }
}

$('li.phover a').click(function(){
    $('li.phover a').removeClass("active-menu");
    $(this).addClass("active-menu");
});

$(document).ready(function(){
    $('li.phover a').removeClass("active-menu");
    $(this).addClass("active-menu");
});