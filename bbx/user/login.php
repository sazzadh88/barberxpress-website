<?php
	require '../config/db.php';
    header('Access-Control-Allow-Origin: *'); 

    
	if(isset($_POST['mobile'],$_POST['password'])){
		
		$mobile = $_POST['mobile'];
		$password = $_POST['password'];
	
	
		$stmt = $conn->prepare("SELECT * FROM users LEFT JOIN wallets ON users.user_mobile = wallets.user_mobile WHERE users.user_mobile = :mobile AND users.user_password = :password ");
		$stmt->execute(array(':mobile'=>$mobile,':password' => $password));
	
		$result = $stmt->fetchObject();
		if(empty($result)){
			echo json_encode(['code' => 401 , 'response' => 'Invalid Login']);
		}else{
		    if($result->user_verified <> 2){
		        echo json_encode(['code' => 200 , 'response'=>'Login successful','data' => $result]);
		    }else{
		        echo json_encode(['code' => 401 , 'response'=>'Your account has been disabled. Please contact admin@barberxpress.in']);
		    }
		}

	}else{
		echo json_encode(['code' => 401 , 'response'=>'Invalid Request.']);
	}