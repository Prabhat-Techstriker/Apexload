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

