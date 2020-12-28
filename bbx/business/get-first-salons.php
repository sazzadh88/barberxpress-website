<?php
require('../config/db.php');

    //$partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT *,NULL AS partner_password, NULL AS partner_otp  FROM business_partners WHERE partner_otp_verified = 1 
	    AND partner_profile_verified =1 ORDER BY partner_id ASC LIMIT 10");
    $stmt->execute();
    $data = [];
    
    while($row = $stmt->fetchObject()){
        $row->rating = getAvgRatings($row->partner_id);
        $row->avg_price = getAvgPrice($row->partner_id);
        $data[] = $row;
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
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
