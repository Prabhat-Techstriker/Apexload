<?php

function getCreatedBy($id) {
$createdby = DB::table('users')
                ->select('*')
                ->where('id', $id);
$resultData = $createdby->first();

$array = json_decode(json_encode($resultData), true);
	if (!empty($array)) {
	   return $array['first_name']. ' ' .$array['last_name'];
	}else{
		return 'N.A';
	}
}

function distance($lat1, $lon1, $unit = "K") {

    $URL = 'https://maps.googleapis.com/maps/api/directions/json?origin='.str_replace(' ', '+', $lat1).'&destination='.str_replace(' ', '+', $lon1).'&key=AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4';
    // $URL = 'https://maps.googleapis.com/maps/api/directions/json?origin=Garhi+Malook+No-1,+Keshav Nagar,+Saharanpur,+Uttar+Pradesh&destination=Delhi+Airport,+New+Delhi,+Delhi&key=AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4';

    $crl = curl_init();

    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
 
    curl_setopt($crl, CURLOPT_URL, $URL);
    //curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
 
    curl_setopt($crl, CURLOPT_POST, 0);
    //curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
 
    $rest = curl_exec($crl);

    $result = json_decode($rest);
    
    //$result = str_replace(' km', '', $result->routes[0]->legs[0]->distance->text);
    $result = $result->routes[0]->legs[0]->distance->text;

    return $result;
}


?>