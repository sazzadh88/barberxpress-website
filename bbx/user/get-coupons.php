<?php
	require '../config/db.php';
	
	    $stmt = $conn->prepare("SELECT * from coupons WHERE is_private = 0");
	    $stmt->execute();
	    while($row = $stmt->fetchObject()){
	        $data[] = $row;
	    }
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	
	
	