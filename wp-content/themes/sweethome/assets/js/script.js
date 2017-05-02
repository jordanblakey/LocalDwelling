// jQuery
(function($) {
  "use strict";
	$(document).ready(function() {
		// Main Slider
		$('.main-flexslider').flexslider({
			directionNav: true, 
			controlNav: false, 
			animation: "fade",
			slideshowSpeed: 7000,
			prevText: "",
			nextText: "",
		});

		// Styling Select elements
		Select.init({selector: '.elselect'});

		// Agents slider
		$(".owl-carousel").owlCarousel({
			items : 2,
			navigation : true,
			pagination : false,
			navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
		});

		//Tab
		$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		})

		// Property-Details page slider
		 $('#details-carousel').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 142,
		    itemMargin: 0,
		    prevText: "",
			nextText: "",
		    asNavFor: '#details-slider'
		  });
		   
		  $('#details-slider').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    sync: "#details-carousel",
			directionNav: false 
		  });

		 // Animated back to top
		 $('#backtop-btn').click(function() {
	        $("html, body").animate({scrollTop: 0}, 600);
	    });

		// Nav Menu
		 /**
		$('.dropdown-toggle').click(function(){
			$('.dropdown-menu').slideToggle(300);
		});
		
		$('.dropdown-toggle').blur(function(){
			$('.dropdown-menu').slideUp(300);
		});
		**/
		// Contact Form
		$("input[type='text'], textarea").keypress(function() {
		  $(this).css({"background-color":"#fff"});
		});
		$(function () {
	        $("#submit-btn").click(function () {
	        	var has_error = 0 ;
	            var name = $("#name").val();
	            var message = $("#message").val();
	            var email = $("#email").val();
	            var website = $("#website").val();
	            var action = $("#action").val();
	            var atpos = email.indexOf("@");
	            var dotpos = email.lastIndexOf(".");
	            var dataString = '&name=' + name + '&email=' + email + '&website=' + website + '&message=' + message +'&action='+action;

	            $('input[type=text]').focus(function () {
	                $(this).css({
	                    "background-color": "#fff"
	                });
	            });
	            $('textarea').focus(function () {
	                $(this).css({
	                    "background-color": "#fff"
	                });
	            });

	            if ($("#name").val().length == 0) {
	           		has_error = 1 ;
	                $('#name').css({
	                    "background-color": "rgba(248, 116, 116, 0.52)"
	                });
	            }
	            if($("#email").val().length == 0) {
	            has_error = 1 ;
	                $('#email').css({
	                    "background-color": "rgba(248, 116, 116, 0.52)"
	                });
	            }
	            if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
	            has_error = 1 ;
	                $('#email').css({
	                    "background-color": "rgba(248, 116, 116, 0.52)"
	                });
	            }
	            if($("#message").val().length == 0) {
	            has_error = 1 ;
	                $('#message').css({
	                    "background-color": "rgba(248, 116, 116, 0.52)"
	                });
	            } 
	            if(has_error == 0 ) {
	               $.ajax({
	                   type: "POST",
	                    url: swh_ajax_uri,
	                    data: dataString,
	                    beforeSend:function(){
	                    	$('.inner-wrapper .alert').removeClass('alert-warning');
	                    	$('.inner-wrapper .alert').removeClass('alert-success');
	                    	$('.inner-wrapper .alert').empty();
	                    	$('form.contact-form input[type="submit"]').val('Sending ...');
	                    },
	                    success: function (data) {
	                    	var data = $.parseJSON(data);
	                    	$('.inner-wrapper .alert').addClass( data.element_class);
	                    	$('.inner-wrapper .alert').append( data.message );
	                    	$('.inner-wrapper .alert').slideDown();
	                    	
	                    	if( data.resp == 'success' ){
	                    		$('#submit-btn').val('SENT!');
	                    		$('#submit-btn').css({
		  		                    "background-color": "#00E681"
		  		                });
	                    		$('form.contact-form').find("input[type=text], textarea").val("");   		
	                    	}
	                    	else{
	                    		$('#submit-btn').val('Send message');
	                    	}
	                    }
	                });
	            }
	            return false;
	        });
	    });
	});
})(jQuery);