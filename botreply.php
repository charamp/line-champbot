<?php
include 'test.php';

$lineAccessToken = 'JVQbtOi6+PdQ10mDBPi61vGacBf9xdi5Vs2vFYOSH8EdhfP01Ptv8CgotQAQbrsxQjXMluidNILBhu4raGdqcF+ne16E8bT6JvOliwseoYw8vqGjhXTK+T4yDYckXOoEfFkFp5MoBgEf6muvlwHp4gdB04t89/1O/w1cDnyilFU=';
// Make a POST Request to Messaging API to reply to sender
$access_token = $lineAccessToken;
$lineTargetUID = "Re15307cef92d8a4e9fc5e566ed9bd140"; 

$replyToken = $lineTargetUID;

$food = Array('kfc', 'บอนชอน', 'พิซซ่า', 'แมค', 'สเต็ก', 'สเวนเซ่น', 'ไม่หิวอะ เลือกเลย', 'แล้วแต่อะ');
$suffixfood = Array('เราอยากกิน', 'ถูกดี', 'ไม่ค่อยมีคนดี');

$content = file_get_contents('php://input');
$events = json_decode($content, true);



if (!is_null($events['events'])) {

				$myfile = fopen("event.txt", "a") or die("Unable to open file!");
				fwrite($myfile, (string) json_encode($events));
				fclose($myfile);

	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = explode(' ', $event['message']['text']);
			if (in_array("แชมป์บอท", $text)) {
				$myfile = fopen("aaa.txt", "a") or die("Unable to open file!");
				fwrite($myfile, (string) json_encode($event));
				fclose($myfile);

				$suffix = Array( str_repeat('5', rand(3,10)), str_repeat('อิ', rand(1,2)) );

				if (strpos($text[1], 'กิน') !== FALSE) {
					$random = rand(0,7);
					if ($random == 6 or $random == 7){
						$reply = $food[$random];
					}
					else {
						$reply = 'เราว่ากิน' . $food[$random] . 'มะ ' . $suffixfood[rand(0,2)]; 
					}
				}		
				else {
					$reply = callApiChat($text[1]) . ' ' . $suffix[rand(0,1)];			
				}

				if ($event['source']['type'] == 'user') {
					$replyToken = $event['source']['userId'];
				}
				elseif ($event['source']['type'] == 'room') {
					$replyToken = $event['source']['roomId'];
				}
				elseif ($event['source']['type'] == 'group') {
					$replyToken = $event['source']['groupId'];
				}
				$myfile = fopen("bbb.txt", "a") or die("Unable to open file!");
                                fwrite($myfile, (string) $replyToken);
                                fclose($myfile);

				if (strpos($reply, 'ควย') !== FALSE or strpos($reply, 'หี') !== FALSE ) {
					$reply = 'เซ็นเซอร์';
				}

				$messages = [
            				'type' => 'text',
                     			'text' => $reply
				];
	
				$url = 'https://api.line.me/v2/bot/message/push';
         			$data = [
            					'to' => $replyToken,
            					'messages' => [$messages]
         				];

		       		$post = json_encode($data);
			        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			        $ch = curl_init($url);
			        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			        $result = curl_exec($ch);
			        curl_close($ch);

                                $myfile = fopen("ccc.txt", "a") or die("Unable to open file!");
                                fwrite($myfile, (string) $post);
                                fclose($myfile);

				fwrite($myfile,(string) $text.' '.date(DATE_RFC2822)."\n");
				fclose($myfile);
			        echo $result . ', message: '.$text. "\r\n";

			}
		}
	}
}



/*

$messages = [
            'type' => 'text',
                     'text' => $text
];
$url = 'https://api.line.me/v2/bot/message/push';
         $data = [
            'to' => $replyToken,
            'messages' => [$messages]
         ];
         $post = json_encode($data);
         $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

         $ch = curl_init($url);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
         $result = curl_exec($ch);
         curl_close($ch);

fwrite($myfile, (string) $text.' '.date(DATE_RFC2822)."\n");
fclose($myfile);
         echo $result . ', message: '.$text. "\r\n";


?>
