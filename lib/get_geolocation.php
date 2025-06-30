<?php

const API_KEY =  "Your API key";


function get_geolocation()
{
	$url = "https://www.googleapis.com/geolocation/v1/geolocate?key=" . API_KEY;

	$data = json_encode([
		"considerIp" => true,
	]);

	$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	try {

		$start = microtime(true);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$end = microtime(true);
		$duration = $end - $start;

		if (curl_errno($ch)) {
			throw new Exception('cURL error: ' . curl_error($ch));
		}

		if ($response === false) {
			throw new Exception('Failed to get location.');
		}

		$response = json_decode($response);

		if ($httpCode !== 200) {
			json_response($httpCode, $response->error->message);
		}

		$data = [
			'lat' => $response->location->lat,
			'lng' => $response->location->lng,
			'accuracy' => round($response->accuracy, 2),
			'speed' => round($duration, 2)
		];

		json_response(0, '', $data);
	} catch (\Exception $e) {
		json_response(111, $e->getMessage());
	}
	curl_close($ch);
}

function json_response($code = 0, $mesage = '', $data = [])
{
	echo json_encode([
		'code' => $code,
		'message' => $mesage,
		'location' => $data
	]);

	die;
}
