<?php

require('../config/db.php');

if(isset($_GET['category_id']))
{
    $id = intval($_GET['category_id']);
    
    $stmt = $conn->prepare("SELECT * FROM merchant_services LEFT JOIN business_partners 
                            ON merchant_services.business_partner_id = business_partners.partner_id
                            WHERE merchant_services.category_id = :category_id");
	$stmt->execute(array(':category_id' => $id));
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode(['code' => 200, 'data' => $data]);
}