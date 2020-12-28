<?php
	require '../config/db.php';
	
	   if(isset($_GET['keyword'])){
	        $name = $_GET['keyword'];
	        $stmt = $conn->prepare("SELECT * from business_partners WHERE (partner_otp_verified = 1 
	    AND partner_profile_verified =1) AND partner_display_name LIKE ?");
	        $params = array("%$name%");
    	    $stmt->execute($params);
    	    $data = [];
    	    while($row = $stmt->fetchObject()){
    	        $data[] = $row;
    	    }
    	    if($data){
    	        echo json_encode(['code' => 200 , 'data'=> $data]);
    	    }else{
    	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
    	    }
	   }else{
	       echo json_encode(['code' => 401 , 'response'=> 'Invalid request']);
	   }
	
	
	