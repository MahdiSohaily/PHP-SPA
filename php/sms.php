<?php /*

$url = 'https://console.melipayamak.com/api/send/simple/ad8de9db40894ba28cefd45d2a730c88';
$data = array('from' => '5000xxx', 'to' => '09123612779', 'text' => 'test sms');
$data_string = json_encode($data);
$ch = curl_init($url);                          
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                      
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

// Next line makes the request absolute insecure
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Use it when you have trouble installing local issuer certificate
// See https://stackoverflow.com/a/31830614/1743997

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER,
  array('Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
  );
$result = curl_exec($ch);
curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }


?>
