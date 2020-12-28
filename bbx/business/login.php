<?php
	require '../config/db.php';
     
	if(isset($_POST['mobile'],$_POST['password'])){
		
		$mobile = $_POST['mobile'];
		$password = $_POST['password'];
	
		$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_mobile = :mobile AND partner_password = :password ");
		$stmt->execute(array(':mobile'=> $mobile,':password' => $password));
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'Invalid Login']);
		}else{
		    echo json_encode(['code' => 200 , 'response'=>'Login successful','data' => $result]);
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request.']);
	}