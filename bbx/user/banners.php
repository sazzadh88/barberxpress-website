<?php
	require '../config/db.php';
	
	    $stmt = $conn->prepare("SELECT * from banners");
	    $stmt->execute();
	    while($row = $stmt->fetchObject()){
	        $row->image_url = APP_URL.$row->image_url;
	        $data[] = $row;
	        
	    }
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	
	
	