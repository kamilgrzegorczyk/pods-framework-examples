<?php
/**
 * Simple geocode snippet to use as pre save filter
 * Author: Kamil Grzegorczyk
 * Version: 1.0
 * Author URI: http://lowgravity.pl
 * 
 * TODO: add JS functionality to display map frame and drop marker using mouse, display current coordinates on map
 * TODO: make coordinates field disabled
 *
 * !!!README!!!
 * Remember to exchange:
 * %%podname%%, %%address_field_name_here%%, %%coordinates_field_name_here%%
 * with correct names of your pods and its fields
 * 
 * If you would like to use multiple address fields then just please concatenate them into one address string. The rest of the process stays the same.
 * 
 */


add_filter('pods_api_pre_save_pod_item_%%podname%%','lowgravity_geo_pre_save',10,2);

function lowgravity_geo_pre_save($pieces, $is_new) {

	$address_field_name     = '%%address_field_name_here%%';
	$coordinates_field_name = '%%coordinates_field_name_here%%';

	//checking if our address field exists
	if(isset($pieces['fields'][$address_field_name])) {

		//parsing data 
		$address = urlencode( strtolower( trim($pieces['fields'][$address_field_name]['value'])));


	} else {// otherwise do nothing

		return $pieces;

	}

	//preparing url
	$geourl = "http://maps.google.com/maps/api/geocode/json?address=". strtolower($address) ."&sensor=false";
	
	//get the geocoded info from Google
	$geoinfo = wp_remote_get($geourl); 

	//default value for coordinates field
	$coordinates = 'Unable to automatically detect coordinates';

	//if the response is OK 
	if( "OK" == $geoinfo['response']['message'] ) {
		
		$json_obj = json_decode($geoinfo['body']);
		$coordinates = $json_obj->results[0]->geometry->location->lat . ',' . $json_obj->results[0]->geometry->location->lng;
	
	} 

	$pieces['fields'][$coordinates_field_name]['value'] = $coordinates;
	
	//returning data	
	return $pieces;
}