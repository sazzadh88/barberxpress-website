<?php
require '../config/db.php';
	
	    if(isset($_GET['id'])){
	       
	        $id = $_GET['id'];
    	    $stmt = $conn->prepare("SELECT * FROM business_partners WHERE service_category = :cat_id");
    	    $stmt->execute([':cat_id' => $id]);
    	    while($row = $stmt->fetchObject()){
    	        $data[] = $row;
    	    }
    	
    	   if(empty($data))
    	   {
    	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
    	   }
    	   else
    	   {
    	       echo json_encode(['code' => 200 , 'data'=> is_null($data) ? [] : $data]);
    	   }
	    
	    }
	
	
	