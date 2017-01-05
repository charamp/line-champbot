<?php

function callApiChat($message) {
	$url = 'http://www.dogdiri.com/chat/dogthink.php';
	$data = array('chattext'=>'สวัสดี');

	// use key 'http' even if you send the request to https://...
	$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        		'method'  => 'POST',
        		'content' => http_build_query($data)
    			)
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	echo $result;
	var_dump($result);

?>
