// JavaScript Document

var map;
var markersArray = [];

function admin_google_map_initilize(canvas_id, lat,lng) {
	// style="width:635px; height:500px;"
	
  var myLatlng = new google.maps.LatLng(lat,lng);
  var myOptions = {
    zoom: 6,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  document.getElementById(canvas_id).style.display='';
  map = new google.maps.Map(document.getElementById(canvas_id), myOptions);
  
  placeMarker(myLatlng);
  google.maps.event.addListener(map, 'click', function(event) {
	deleteMarkers();
    placeMarker(event.latLng);
  });
}
  
function placeMarker(location) {

  //alert( location.lat() + ", lng: " + location.lng() );

  $('[name=latitude]').val(location.lat() );
  $('[name=longitude]').val(location.lng() );
  
  var marker = new google.maps.Marker({
      position: location, 
      map: map
  });
  markersArray.push(marker);

  map.setCenter(location);
}

// Deletes all markers in the array by removing references to them
function deleteMarkers() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;
  }
}


function google_map_initilize(canvas_id, lat,lng,zoom_level,info) {

var myLatlng = new google.maps.LatLng(lat,lng);
  var myOptions = {
    zoom: 8,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById(canvas_id), myOptions);
  placeMarker(myLatlng);
}

//google_map_mini_initilize
function google_map_mini_initilize(canvas_id, lat,lng,zoom_level,info) {

var myLatlng = new google.maps.LatLng(lat,lng);
  var myOptions = {
    zoom: 8,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		zoomControl: false
  }
  map = new google.maps.Map(document.getElementById(canvas_id), myOptions);
  placeMarker(myLatlng);
}

/// route_maps
function google_route_map_initilize(canvas_id, points) {

    var routeCoordinates=[];
	var firstPoint = new google.maps.LatLng(0, -180);
	var bounds = new google.maps.LatLngBounds();


	
	if(points.length >0){
		$.each(points, function() {
			routeCoordinates.push( new google.maps.LatLng(this.latitude, this.longitude)  );
		});
	}
	
	if(routeCoordinates.length >0){
		firstPoint=routeCoordinates[0];
	}

	
	
	 var gOptions = {
      zoom: 6,
      center: firstPoint,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
	  panControl: true,
	  zoomControl: true,
	  mapTypeControl: true,
	  scaleControl: true,
	  streetViewControl: true
    };
	
	var map = new google.maps.Map(document.getElementById(canvas_id), gOptions);
	
	 // Draw polygon
    var routePath = new google.maps.Polyline({
      path: routeCoordinates,
      strokeColor: "#FF0000",
      strokeOpacity: 0.5,
      strokeWeight: 4
    });
   routePath.setMap(map);
   
   
    // Set markers
	if(points.length >0){
		$.each(points, function() {
			var location =new google.maps.LatLng(this.latitude, this.longitude);
			bounds.extend(location);
			
			var marker = new google.maps.Marker({
				  position: location, 
				  map: map
			  });
			 
			 attachInfoWindow(map,marker, this.place);
		});
	}
	
	// Set Center and zoom level
	map.fitBounds(bounds);

	
}


function attachInfoWindow(map,marker, message) {
  var infowindow = new google.maps.InfoWindow({ 
		content: message,
        size: new google.maps.Size(50,50)
      });
  
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}




//google_route_map_mini_initilize
function google_route_map_mini_initilize(canvas_id,points) {
	var routeCoordinates=[];
	var firstPoint = new google.maps.LatLng(0, -180);
	var bounds = new google.maps.LatLngBounds();


	
	if(points.length >0){
		$.each(points, function() {
			routeCoordinates.push( new google.maps.LatLng(this.latitude, this.longitude)  );
		});
	}
	
	if(routeCoordinates.length >0){
		firstPoint=routeCoordinates[0];
	}

	var gOptions = {
      zoom: 6,
      center: firstPoint,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
	  panControl: false,
	  zoomControl: false,
	  mapTypeControl: false,
	  scaleControl: false,
	  streetViewControl: false

	  
    };
	
	var map = new google.maps.Map(document.getElementById(canvas_id), gOptions);
	
	// Draw polygon
		
	var routePath = new google.maps.Polyline({
	  path: routeCoordinates,
	  strokeColor: "#FF0000",
	  strokeOpacity: 0.5,
	  strokeWeight: 2
	});
	
	routePath.setMap(map);
   
   
    // Set markers
	if(routeCoordinates.length >0){
		$.each(routeCoordinates, function() {	
			bounds.extend(this);
			/*
			 var marker = new google.maps.Marker({
				  position: this, 
				  map: map
			  });
			*/
		});
	}
	
	// Set Center and zoom level
	map.fitBounds(bounds);
  
}


