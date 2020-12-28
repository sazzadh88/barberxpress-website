<?php

require('../config/db.php');
require('../config/func.php');


if(isset($_POST['email'],$_POST['mobile'],$_POST['password'])){
    
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password = $_POST['password'];
	$otp = mt_rand(100000, 999999);
	

	$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_mobile = :mobile");
	$stmt->execute(array(':mobile' => $mobile));
	$result = $stmt->fetchObject();

	if(empty($result)){
		$stmt = $conn->prepare("INSERT INTO business_partners (partner_email,partner_mobile,partner_password,partner_otp) VALUES(:email,:mobile,:password,:partner_otp)");
		$data = array(
					':email'=>$email,
					':mobile'=>$mobile,
					':password'=>$password,
					':partner_otp' => $otp
				);
		$stmt->execute($data);
		if($stmt->rowCount() == 1){
		    $sms = (new Sms)->send($mobile,'Your verification code is: '.$otp);
			echo json_encode(['response'=>'Registration successful & OTP Verification is peniding.','code' => 200]);
		}else{
		    echo json_encode(['response'=>'Registration Failed','code' => 401]);
		}
	}else{
		echo json_encode(['response'=>'This mobile number is already registered','code' => 401]);
	}
    
}else{
    echo json_encode(['response'=>'Invalid Request','code' => 401]);
}