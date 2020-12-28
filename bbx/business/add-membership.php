<?php

require('../config/db.php');

if(isset($_POST['partner_id'])){
    
	$partner_id = $_POST['partner_id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$tnc = $_POST['tnc'];

	$price = $_POST['price'];
	$validity = $_POST['validity'];
	$discount_value = $_POST['discount_value'];
	$usage_limit = $_POST['usage_limit'];


	$stmt = $conn->prepare("INSERT INTO memberships (partner_id,title,description,tnc,price,discount_value,validity,usage_limit) 
	VALUES(:partner_id,:title,:description,:tnc,:price,:discount_value,:validity,:usage_limit)");
	$data = array(
				':partner_id'=> $partner_id,
				':title'=> $title,
				':description'=> $description,
				':tnc'=> $tnc,
				':price'=> $price,
				':validity' => $validity,
				':discount_value' => $discount_value,
				':usage_limit' => $usage_limit
			);
	
	$stmt->execute($data);
	
	if($stmt->rowCount() == 1){
		echo json_encode(['response'=>'Memberships has been added successfully','code' => 200]);
	}else{
	    echo json_encode(['response'=>'Failed','code' => 401]);
	}
	
    
}else{
    echo json_encode(['response'=>'Invalid Request','code' => 401]);
}