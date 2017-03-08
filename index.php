<?php
// parameters
$hubVerifyToken = 'TOKEN111';
$accessToken = "EAACXoXp8gMQBAJqFzy9mYKpIRJUz5nf2zaZCgUIaLYdsVRPv4QQtGQJheDN305LYAMN3LRh1B0xrZADLtQZCIZBFJSZBfW3HHNKaCWl8L3IoGcUIk4wzi2ZBwseEndis5B0D3lukGWvAUcy3uKvI2cdW69dbNrGhrCQ4rvG2U32QZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];

curl -X POST -H "Content-Type: application/json" -d '{
  "recipient":{
  	"id":"USER_ID"
  },
  "sender_action":"typing_on"
}' "https://graph.facebook.com/v2.6/me/messages?access_token=AACXoXp8gMQBAJqFzy9mYKpIRJUz5nf2zaZCgUIaLYdsVRPv4QQtGQJheDN305LYAMN3LRh1B0xrZADLtQZCIZBFJSZBfW3HHNKaCWl8L3IoGcUIk4wzi2ZBwseEndis5B0D3lukGWvAUcy3uKvI2cdW69dbNrGhrCQ4rvG2U32QZDZD" 


$answer = "I don't understand. Ask me 'hi'.";
if($messageText == "hi") {
    $answer = "Hello";
}

if($messageText == "jeldon") {
    $answer = "gwapo";
}

if($messageText == "sure?") {
    $answer = "lagi";
}

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

//based on http://stackoverflow.com/questions/36803518
