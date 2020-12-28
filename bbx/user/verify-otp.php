<?php
	require '../config/db.php';
// 	require '../config/func.php';

	if(isset($_POST['mobile'],$_POST['otp'])){
		$mobile = $_POST['mobile'];
		$otp = $_POST['otp'];

		$stmt = $conn->prepare("SELECT * FROM users WHERE user_mobile = :mobile AND user_otp = :otp");
		$stmt->execute(array(':mobile'=>$mobile,':otp'=>$otp));
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'Invalid OTP']);
		}else{
			$stmt = $conn->prepare("UPDATE users SET user_verified = 1 WHERE user_mobile= :mobile");
			$stmt->execute(array(':mobile'=>$mobile));
			if($stmt->rowCount() == 1){
				echo json_encode(['code' => 403 , 'response'=>'Mobile number has been verified successfully', 'data' => $result]);
			}else{
				echo json_encode(['code' => 401 , 'response'=>'Mobile number is already verified']);
			}
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request']);
	}