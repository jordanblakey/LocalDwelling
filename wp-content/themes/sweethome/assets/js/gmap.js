function initialize( lat, lng, element ) {
    var map_canvas = document.getElementById(element);
    var myLatlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        center: myLatlng,
        zoom: 17,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(map_canvas, mapOptions); 
    TestMarker( lat, lng );
}
// Function for adding a marker to the page.
function addMarker(location) {
	var $icon = swh_template_uri+'/assets/img/property-marker.png'
	var $custom_icon = jQuery('#property-location-map').attr('data-icon');
	
	if( $custom_icon != '' ){
		$icon = $custom_icon;
	}
	
    marker = new google.maps.Marker({
        position: location,
        icon: $icon,
        map: map
    });
}
function TestMarker( lat, lng ) {
    MyMarker = new google.maps.LatLng(lat, lng);
    addMarker(MyMarker);
}