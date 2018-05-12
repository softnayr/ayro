<?php
	$username = "softnayr";
	$apiKey = "f5304a7e4fe9ee382f64a39cc7e6e5b63b04731b";
	$fxmlUrl = "https://flightxml.flightaware.com/json/FlightXML3/";


	$queryParams = array(
	'ident' => 'CEB556',
	'howMany' => 5,
	'offset' => 5
);



	$endpoint = 'FlightInfoStatus';
	$url = $fxmlUrl . $endpoint . '?' . http_build_query($queryParams);
	

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $apiKey);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // FOR TESTING PURPOSES ONLY
               
        
        $response = curl_exec($ch);
        curl_close($ch);

        echo '<pre>';

        print_r(json_decode($response)); 
        echo '<pre>--------';
        

        $result = [];

        $flightArray = json_decode($response, true);


        
	foreach ($flightArray['FlightInfoStatusResult']['flights'] as $flight) {
		// if ($flight['actual_departure_time']['epoch'] > 0 && $flight['route']) {
			$result['ident'] = $flight['ident'];
			$result['faFlightID'] = $flight['faFlightID'];
			$result['origin'] = $flight['origin']['code'];
			$result['origin_name'] = $flight['origin']['airport_name'];
			$result['destination'] = $flight['destination']['code'];
			$result['destination_name'] = $flight['destination']['airport_name'];
			$result['date'] = $flight['filed_departure_time']['date'];
			$result['waypoints'] = getFlightRoute($flight['faFlightID']);
			echo '<pre>';
			echo  json_encode($result);
			echo '</pre>';
			// }
	}


	// if ($result = curl_exec($ch)) {
	// 	curl_close($ch);
	// 	return $result;
	// }
	// return;
// if ($response = executeCurlRequest('FlightInfoStatus', $queryParams)) {

	
// 	$flightArray = json_decode($response, true);
// 	foreach ($flightArray['FlightInfoStatusResult']['flights'] as $flight) {
// 		if ($flight['actual_departure_time']['epoch'] > 0 && $flight['route']) {
// 			$result['ident'] = $flight['ident'];
// 			$result['faFlightID'] = $flight['faFlightID'];
// 			$result['origin'] = $flight['origin']['code'];
// 			$result['origin_name'] = $flight['origin']['airport_name'];
// 			$result['destination'] = $flight['destination']['code'];
// 			$result['destination_name'] = $flight['destination']['airport_name'];
// 			$result['date'] = $flight['filed_departure_time']['date'];
// 			$result['waypoints'] = getFlightRoute($flight['faFlightID']);
// 			echo json_encode($result);
// 			return;
// 		}
// 	}
// } else {
// 	echo json_encode(array('error' => 'Unable to decode flight for ' . $ident));
// }
function getFlightRoute($faFlightID) {
	$result = [];
	if ($response = executeCurlRequest('DecodeFlightRoute', array('faFlightID' => $faFlightID))) {
		$flightPoints = json_decode($response, true);
		foreach ($flightPoints['DecodeFlightRouteResult']['data'] as $point) {
			array_push($result, array('lat' => $point['latitude'], 'lng' => $point['longitude']));
		}
		return $result;
	}
	return "";
}
function executeCurlRequest($endpoint, $queryParams) {
	$username = "softnayr";
	$apiKey = "f5304a7e4fe9ee382f64a39cc7e6e5b63b04731b";
	$fxmlUrl = "https://flightxml.flightaware.com/json/FlightXML3/";
	$url = $fxmlUrl . $endpoint . '?' . http_build_query($queryParams);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $apiKey);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
	$result = curl_exec($ch);

	var_dump($result);

	// if ($result = curl_exec($ch)) {
	// 	curl_close($ch);
	// 	return $result;
	// }
	// return;
}