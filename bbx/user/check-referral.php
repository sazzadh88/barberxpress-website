<?php
	require '../config/db.php';
	
	    $referral_code = $_GET['referral_code'];
	    $stmt = $conn->prepare("SELECT user_id,user_name,user_mobile from users WHERE ref_code = :ref_code");
	    $stmt->execute([':ref_code' => $referral_code]);
	    $row = $stmt->fetchObject();
	      
	    if($row){
	        echo json_encode(['code' => 200 , 'data'=> $row]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'Invalid referral code']);
	    }
	
	