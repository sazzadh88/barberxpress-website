<?php
	require '../config/db.php';
	
	   // $service_category = $_GET['service_category'];
	    $stmt = $conn->prepare("SELECT *, AVG(services.service_price) as avg_price FROM business_partners LEFT 
	    JOIN services ON business_partners.partner_id = services.partner_id WHERE business_partners.partner_profile_verified = 1 AND 
	    business_partners.partner_otp_verified = 1 GROUP BY services.partner_id");
	    $stmt->execute();
	    while($row = $stmt->fetchObject()){
	        $data[] = $row;
	    }
	    
	    $keys = array_column($data, 'avg_price');

        array_multisort($keys, SORT_ASC, $data);
    
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	
	