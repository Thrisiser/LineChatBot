<?php
 echo "Hello, I am Captain America!/n";
 echo "Send me a Line Message!";
 $json_str = file_get_contents('php://input'); //接收REQUEST的BODY
 $json_obj = json_decode($json_str); //轉JSON格式
 
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $response = array (
				"to" => $sender_userid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "你好，你剛才說的話是....「".$sender_txt."」。"
					)
				)
		);

 $myfile = fopen("log.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
 fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前加入\xEF\xBB\xBF轉成utf8格式 大小寫有差
 fclose($myfile);

 //回傳給line server
	$header[] = "Content-Type: application/json";
	$header[] = "Authorization: Bearer 2dlO4f5JCjLNWypaXTnItbtxhIVQLKAGvPv1GS3aNUxYs7MUKu5jtsRzAO+TqN2G6ksPVi+KForszbV4NXXTSLBnchyaZ4wTPP7OgLfeTXgXz1YjlD1G3RC/iMwSmmVocmFnqG8QHrcm1v/ASkKbqQdB04t89/1O/w1cDnyilFU=";
	$ch = curl_init("https://api.line.me/v2/bot/message/push");                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
	$result = curl_exec($ch);
	curl_close($ch); 
?>
