<?php
require '../config/db.php';
	
	    if(isset($_POST['cat_id'])){
	       
	        $cat_id = $_POST['cat_id'];
    	    $stmt = $conn->prepare("SELECT * FROM services WHERE category = :cat_id ORDER BY service_name ASC");
    	    $stmt->execute([':cat_id' => $cat_id]);
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
	
	
	