<?php
	require '../config/db.php';
     
	if(isset($_POST['barber_login_id'],$_POST['barber_password'])){
		
		$barber_login_id = $_POST['barber_login_id'];
		$barber_password = $_POST['barber_password'];
	
		$stmt = $conn->prepare("SELECT * FROM barbers WHERE barber_login_id = :barber_login_id AND barber_password = :barber_password ");
		$stmt->execute(array(':barber_login_id'=> $barber_login_id,':barber_password' => $barber_password));
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'Invalid Login']);
		}else{
		    echo json_encode(['code' => 200 , 'response'=>'Login successful','data' => $result]);
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request.']);
	}