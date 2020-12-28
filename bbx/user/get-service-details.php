<?php
	require '../config/db.php';
	
	if(isset($_GET['cat_id'])){
	    
	    $cat_id = $_GET['cat_id'];
	    if(isset($_GET['sub_cat_id'])){
	        $sub_cat_id = $_GET['sub_cat_id'];
	        $stmt = $conn->prepare("SELECT services.*, business_partners.partner_address,business_partners.partner_specialization,business_partners.partner_mobile,
    	    business_partners.partner_display_name,business_partners.partner_category,business_partners.partner_sub_category  
    	    FROM services LEFT JOIN business_partners ON business_partners.partner_id = services.partner_id WHERE services.category = :category AND services.sub_category = :sub_category");
    	    $stmt->execute([':category' => $cat_id, 'sub_category' => $sub_cat_id]);
	    }else{
	        $stmt = $conn->prepare("SELECT services.*, business_partners.partner_address,business_partners.partner_specialization,business_partners.partner_mobile,
    	    business_partners.partner_display_name,business_partners.partner_category,business_partners.partner_sub_category  
    	    FROM services LEFT JOIN business_partners ON business_partners.partner_id = services.partner_id WHERE services.category = :category");
    	    $stmt->execute([':category' => $cat_id]);
	    }
	    
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
	    echo json_encode(['code' => 401 , 'response'=> 'Invalid Request']);
	}
	
	