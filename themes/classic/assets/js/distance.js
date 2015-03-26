var render_distance;
(function(){

var EARTH_RADIUS = 6378137.0; //单位M 
var PI = Math.PI; 

function getRad(d){ 
	return d*PI/180.0; 
} 

function getGreatCircleDistance(lat1,lng1,lat2,lng2){ 
	var radLat1 = getRad(lat1); 
	var radLat2 = getRad(lat2); 

	var a = radLat1 - radLat2; 
	var b = getRad(lng1) - getRad(lng2); 

	var s = 2*Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) + Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2))); 
	s = s*EARTH_RADIUS; 
	s = Math.round(s*10000)/10000.0; 

	return s; 
} 

render_distance = function(longitude,latitude){
	$('.geo-distance').each(function(i,e){
		// var unit = $(e).attr('data-unit');
		// if(unit==null)
		// 	unit = 'km';
		var lng = $(e).attr('data-longitude');
		var lat = $(e).attr('data-latitude');
		var distance = getGreatCircleDistance(lat,lng,latitude,longitude);
		var res = distance+'m';
		if(distance>1000)
			distance = (distance/1000).toFixed(1)+'km';
		$(e).text(distance);
	});
}

})(); 
