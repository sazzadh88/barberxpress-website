<?php

require('../config/db.php');

if(isset($_POST['user_id'],$_POST['service_id'],$_POST['qty'],$_POST['price'],$_POST['partner_id'])){

	$user_id = $_POST['user_id'];
	$service_id = $_POST['service_id'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$inner_slot_id = 1;
	$partner_id = $_POST['partner_id'];

	$stmt = $conn->prepare("SELECT * FROM carts WHERE user_id = :user_id AND service_id = :service_id");
	$stmt->execute([':user_id' => $user_id, ':service_id' => $service_id]);
	if($stmt->rowCount() >= 1){
	    echo json_encode(['response'=>'Already added to cart', 'code' =>401]); exit;
	}
	
	$stmt = $conn->prepare("INSERT INTO carts values(:id,:user_id,:service_id,:qty,:price,:inner_slot_id,:partner_id)");
	$stmt->execute([
	        ':id' => NULL,
	        ':user_id' => $user_id,
	        ':service_id' => $service_id,
	        ':qty' => $qty,
	        ':price' => $price,
	        ':inner_slot_id' => $inner_slot_id,
	        ':partner_id' => $partner_id
	    ]);

	if($stmt->rowCount() == 1){
	    
	    $stmt = $conn->prepare("SELECT services.service_name,carts.* FROM carts LEFT JOIN services ON services.id = carts.service_id WHERE carts.user_id = :user_id");
	    $stmt->execute([':user_id' => $user_id]);
	    $cart_data = [];
	    while($row = $stmt->fetchObject()){
	        $cart_data[] = $row;
	    }
	    
		echo json_encode(['response'=>'Added to cart','cart_data' => $cart_data, 'code' => 200]);
	}else{
	    echo json_encode(['response'=>'Error', 'code' =>401]);
	}
    
}else{
    echo json_encode(['response'=>'Invalid Request', 'code' =>401]);
}