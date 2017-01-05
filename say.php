<?php
$lineAccessToken = 'JVQbtOi6+PdQ10mDBPi61vGacBf9xdi5Vs2vFYOSH8EdhfP01Ptv8CgotQAQbrsxQjXMluidNILBhu4raGdqcF+ne16E8bT6JvOliwseoYw8vqGjhXTK+T4yDYckXOoEfFkFp5MoBgEf6muvlwHp4gdB04t89/1O/w1cDnyilFU=';
// Make a POST Request to Messaging API to reply to sender
$access_token = $lineAccessToken;
$lineTargetUID = "C9e2a035e10bf19d8af5ae9eb88a5cebb"; 

$replyToken = $lineTargetUID;
$text  = isset($_POST['message'])?$_POST['message']:'';
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
