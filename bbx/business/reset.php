<?php
	require '../config/db.php';
	require '../config/func.php';
     
	if(isset($_POST['mobile'])){
		
		$mobile = $_POST['mobile'];
	
		$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_mobile = :mobile");
		$stmt->execute(array(':mobile'=> $mobile));
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'User does not exist.']);
		}else{
		    (new Sms)->send($mobile,'You password is : '.$result->partner_password);
		    echo json_encode(['code' => 200 , 'response'=>'Password has been sent to your registered mobile.']);
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request.']);
	}