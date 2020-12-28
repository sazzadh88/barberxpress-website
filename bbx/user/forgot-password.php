<?php
	require '../config/db.php';
// 	require '../config/func.php';

	if(isset($_POST['mobile'])){
		$mobile = $_POST['mobile'];
		$otp = mt_rand(100000, 999999);

		$stmt = $conn->prepare("SELECT * FROM users WHERE user_mobile = :mobile");
		$stmt->execute(array(':mobile'=>$mobile));
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'Given mobile number was not found.']);
		}else{
			$stmt = $conn->prepare("UPDATE users SET user_password = :password WHERE user_mobile= :mobile");
			$stmt->execute(array(':mobile'=>$mobile,':password' => $otp));
			if($stmt->rowCount() == 1){
				echo json_encode(['code' => 200 , 'response'=>'New password has been sent to your device.']);
			}else{
				echo json_encode(['code' => 401 , 'response'=>'Password was already updated.']);
			}
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request.']);
	}