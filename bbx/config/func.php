<?php
Class Sms{
    function send($no,$sms){
       	$url = "http://admin.bulksmslogin.com/api/sendhttp.php?authkey=155510AUpiW78v3593ae3f7&mobiles=".$no."&message=".rawurlencode($sms)."&sender=BBQEXP&route=4&country=91";      
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
?>