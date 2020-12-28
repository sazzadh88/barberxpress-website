<?php
	require('../config/db.php');

	if(isset($_POST['mobile'],$_POST['otp'])){
		$mobile = $_POST['mobile'];
		$otp = $_POST['otp'];

		$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_mobile = :mobile AND partner_otp = :otp");
		$stmt->execute(array(':mobile'=>$mobile,':otp'=>$otp));
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'Invalid OTP']);
		}else{
			$stmt = $conn->prepare("UPDATE business_partners SET partner_otp_verified = 1 WHERE partner_mobile= :mobile");
			$stmt->execute(array(':mobile'=>$mobile));
			if($stmt->rowCount() == 1){
				echo json_encode(['code' => 200 , 'response'=>'Mobile number has been verified successfully']);
			}else{
				echo json_encode(['code' => 401 , 'response'=>'Mobile number is already verified']);
			}
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request']);
	}