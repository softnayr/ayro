<?php
$username = "softnayr";
$apiKey = "f5304a7e4fe9ee382f64a39cc7e6e5b63b04731b";
$fxmlUrl = "https://flightxml.flightaware.com/json/FlightXML3/";

$queryParams = array(
    'ident' => 'SWA35',
    'howMany' => 10,
    'offset' => 10
);
$url = $fxmlUrl . 'FlightInfoStatus?' . http_build_query($queryParams);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

if ($result = curl_exec($ch)) {
    curl_close($ch);
    echo $result;
}
?>		