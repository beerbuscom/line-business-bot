<?php





function pushMessage_text($access_token,$userID,$text){
    

	$arrHeader = array();
	$arrHeader[] = "Content-Type: application/json";
	$arrHeader[] = "Authorization: Bearer {$access_token}";
	
	$arrPostData = array();
	$arrPostData['to'] = $userID;
	$arrPostData['messages'][0]['type'] = "text";
	$arrPostData['messages'][0]['text'] = $text;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,'https://api.line.me/v2/bot/message/push');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	
	
	
	$result = curl_exec($ch);
	//echo curl_error($ch);	
	curl_close ($ch);
	
	return ($result);
}

function pushMessage_sticker($access_token,$userID,$packageId,$stickerId){
    

	$arrHeader = array();
	$arrHeader[] = "Content-Type: application/json";
	$arrHeader[] = "Authorization: Bearer {$access_token}";
	
	$arrPostData = array();
	$arrPostData['to'] = $userID;
	$arrPostData['messages'][0]['type'] = "sticker";
	$arrPostData['messages'][0]['packageId'] = $packageId;
	$arrPostData['messages'][0]['stickerId'] = $stickerId;
	
	{
  
}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,'https://api.line.me/v2/bot/message/push');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	
	
	
	$result = curl_exec($ch);
	//echo curl_error($ch);	
	curl_close ($ch);
	
	return ($result);
}







// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);



$strAccessToken = $events[AccessToken];


$strUrl = "https://api.line.me/v2/bot/message/reply";



  

// Validate parsed JSON data
if (!is_null($events[events_line]['events'])) {
	
	
	 // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events[events_line]['events'][0]['replyToken'];
    $userID = $events[events_line]['events'][0]['source']['userId'];
    $sourceType = $events[events_line]['events'][0]['source']['type'];        
    $is_postback = NULL;
    $is_message = NULL;
	
	/*$getprofile = getProfile($strAccessToken,$userID);
	$getprofileObject = json_decode($getprofile);
	$userDisplayName = $getprofileObject->displayName;
	$userPictureUrl = $getprofileObject->pictureUrl;*/
	
	// Loop through each event
	foreach ($events[events_line]['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			
			
				//$arrHeader = array();
				//$arrHeader[] = "Content-Type: application/json";
				//$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
				 
				//$arrPostData = array();
				//$arrPostData['replyToken'] = $events[events_line]['events'][0]['replyToken'];
				//$arrPostData['messages'][0]['type'] = "text";
				//$arrPostData['messages'][0]['text'] = $event['message']['text'];
				
					
					
						pushMessage_text($strAccessToken,$userID,'คุณพิมพ์คำว่า : '.$event['message']['text']);
					
				
					
		}else if($event['type'] == 'message' && $event['message']['type'] =='sticker'){
				
				$p = rand(1,2);
				if($p==1){
					
					pushMessage_sticker($strAccessToken,$userID,2,rand(140,179));
				}else{
					pushMessage_sticker($strAccessToken,$userID,1,rand(1,17));
				}
				
				//pushMessage_text($strAccessToken,$userID,$p);
				
				
				
		}else{
				pushMessage_sticker($strAccessToken,$userID,2,149);
		}
	}



//////บันทึกข้อมูลที่ส่งมา//////////////	
/*$strFileName = "bot_receive_data.txt";


$myfile = fopen($strFileName, "r") or die("Unable to open file!");
$filedata = fread($myfile,filesize($strFileName));
//fclose($myfile);

$objFopen = fopen($strFileName, 'w');

$strText1 = $filedata.json_encode($events).",\r\n";
$filedata ='';
fwrite($objFopen, $strText1);
fclose($objFopen);*/
//////บันทึกข้อมูลที่ส่งมา//////////////	

}
?>
