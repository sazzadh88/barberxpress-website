<?php
	require '../config/db.php';
	
	    if(isset($_GET['partner_id'])){
	       $partner_id = $_GET['partner_id'];
    	    $stmt = $conn->prepare("SELECT * from offers WHERE partner_id = :partner_id");
    	    $stmt->execute(['partner_id' => $partner_id]);
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
	        $stmt = $conn->prepare("SELECT * from offers");
    	    $stmt->execute();
    	    $data = [];
    	    while($row = $stmt->fetchObject()){
    	        $data[] = $row;
    	    }
    	      
    	    if($data){
    	        echo json_encode(['code' => 200 , 'data'=> $data]);
    	    }else{
    	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
    	    }
	    }
	