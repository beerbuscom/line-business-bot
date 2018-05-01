<?php

$access_token = 'eF1ERIEGeVZTqewnN/40ZB29z+ymgX5as0il48qpuviVbhSQkETK7SbZRf3ugvuLFbyNDQbEnUQ4Ug2ePTiTr13ohmw5faJJmZTCSrA4Rru1wRN3O7Yz6Lp8DRDCS90MhlHPwDDBldQe/auHMfjODgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			if(strtolower($event['message']['text'])=='userid'){
			// Get text sent
			//$text = $event['message']['text']. "\r\n".json_encode($event['source']['userId']);
			$text = 'userId = '.json_encode($event['source']['userId'])."\r\n".json_encode($event);
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
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
			
			echo $result . "\r\n";
			}
		}
	}
}

?>



