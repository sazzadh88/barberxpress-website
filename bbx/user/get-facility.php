<?php
	require '../config/db.php';
	
	    $partner_id = $_GET['partner_id'];
	    $stmt = $conn->prepare("SELECT * from facilities WHERE partner_id = :partner_id");
	    $stmt->execute(['partner_id' => $partner_id]);
	    $row = $stmt->fetchObject();
	      
	    if($row){
	        echo json_encode(['code' => 200 , 'data'=> $row]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	
	