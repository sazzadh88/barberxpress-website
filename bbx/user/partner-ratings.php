<?php
	require '../config/db.php';
	
	if(isset($_GET['partner_id'], $_GET['limit'])){
	    $partner_id = $_GET['partner_id'];
	    $limit = $_GET['limit'];
	    $stmt = $conn->prepare("SELECT users.user_name,business_partners.partner_display_name, ratings.* from ratings 
	    LEFT JOIN business_partners ON business_partners.partner_id = ratings.partner_id
	    LEFT JOIN users ON users.user_id = ratings.user_id 
	    WHERE ratings.partner_id = :partner_id 
	    ORDER BY ratings.review_date DESC LIMIT $limit");
	    $stmt->execute([':partner_id' => $partner_id]);
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
	
	