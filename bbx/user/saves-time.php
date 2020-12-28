<?php
	require '../config/db.php';
	
	    //$service_category = $_GET['service_category'];
	    $stmt = $conn->prepare("SELECT services.*, business_partners.partner_address,business_partners.partner_specialization,business_partners.partner_mobile,
	    business_partners.partner_display_name,business_partners.partner_category,business_partners.partner_sub_category  
	    FROM services LEFT JOIN business_partners ON business_partners.partner_id = services.partner_id ORDER BY services.service_time ASC LIMIT 20");
	    $stmt->execute();
	    while($row = $stmt->fetchObject()){
	        $row->rating = getAvgRatings($row->partner_id);
            $row->avg_price = getAvgPrice($row->partner_id);
	        $data[] = $row;
	    }
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	
	function getAvgRatings($partner_id){
        
        global $conn;
        
        $stmt2 = $conn->prepare("SELECT CAST(AVG(rating_value) AS DECIMAL(2,1)) as avg_rating , COUNT(*) as total_rating FROM ratings WHERE partner_id = :partner_id");
        $stmt2->execute([':partner_id' => $partner_id]);
        $data = $stmt2->fetchObject();
        return $data;
        
    }
    
    function getAvgPrice($partner_id){
        
        global $conn;
        
        $stmt2 = $conn->prepare("SELECT CAST(AVG(service_price) AS DECIMAL(6,2)) as avg_price FROM services WHERE partner_id = :partner_id");
        $stmt2->execute([':partner_id' => $partner_id]);
        $data = $stmt2->fetchObject();
        return $data->avg_price;
    }

	