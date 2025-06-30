<?php

require_once('../lib/get_geolocation.php');


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
	get_geolocation();
}
