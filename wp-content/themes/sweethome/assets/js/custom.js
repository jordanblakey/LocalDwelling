// jQuery
$('.dsidx-photo img').css("max-width", "none");
$('.dsidx-photo img').attr('style', 'max-width: none !important');

(function($) {
  "use strict";

	$(document).ready(function(){

		try {

			$('.comment-form-wrapper #commentform').attr("class","contact-form");

			$('.widget_recent_entries > ul > li > a').each(function(){
				jQuery(this).prepend('<i class="fa fa-arrow-circle-right"></i>&nbsp;');
			});
			$('.widget_contact-form-wrapper').addClass('contact-form-wrapper');
			$('.sidebar-widget select').addClass('form-control');
			$('.sidebar-widget table').addClass('table');

			/** Active tabbed widget li **/
			$( "div.tabbed-content ul li" ).first().addClass('active');
			$( "div.tab-content div" ).first().addClass('active in');

			$('.listing-single-item').matchHeight();

		} catch (e) {
			// TODO: handle exception
		}

        // Coloring select boxes after activated
        $(".dsidx-resp-select").on("change", function(){
            $(this).css("color", "#333");
        });

        $(".dsidx-beds").on("change", function(){
            $(this).css("color", "#333");
            console.log("beds")
        });

        $(".dsidx-baths").on("change", function(){
            $(this).css("color", "#333");
            console.log('baths');
        });

        // Centering Slider images
        $('.dsidx-expanded .featured-listing').matchHeight();

        // Featured Listing Labels on Home Page
        $(".dsidx-photo").prepend('<span><i class="fa fa-star"></i> Featured Listing</span>');

        // Append Search to body
        $('#dsidx-quicksearch-2').appendTo("header");
        $('#dsidx-quicksearch-3').appendTo("header");

        // Fixing a bug with mobile menu persisting on window resize
        $( window ).resize(function(){
            $('#bs-example-navbar-collapse-1').removeClass('in');
        });



	})


})(jQuery);
