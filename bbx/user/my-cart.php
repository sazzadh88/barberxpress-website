<?php
	require '../config/db.php';
	
	if(isset($_POST['user_id'])){
	    $user_id = $_POST['user_id'];
	    $stmt = $conn->prepare("SELECT *  from carts LEFT JOIN services ON carts.service_id = services.id WHERE carts.user_id = :user_id");
	    $stmt->execute([':user_id' => $user_id]);
	    
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
	
	