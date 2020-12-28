<?php
header("Content-Type: application/json");
require '../config/db.php';
	
	    $stmt = $conn->prepare("SELECT * FROM rewards WHERE expires_on >= CURDATE() ORDER BY id ASC");
	    $stmt->execute();
	    $data = [];
	    while($row = $stmt->fetchObject()){
	        $data[] = $row;
	    }
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> is_null($data) ? [] : $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	
	
	