<?php

require('../config/db.php');


if(isset($_POST['barber_id'])){
    
	$barber_name = $_POST['barber_name'];	
	$barber_exp = $_POST['barber_exp'];	
	$barber_cutting_type = $_POST['barber_cutting_type'];	
	$barber_best_in = $_POST['barber_best_in'];	
	$barber_login_id = $_POST['barber_login_id'];	
	$barber_password = $_POST['barber_password'];	
	$barber_payout = $_POST['barber_payout'];
	$barber_id = $_POST['barber_id'];
    
    $barber_image = $_POST['barber_image'];
   
    $barber_image_name = $barber_id .'-'. uniqid().".png";
    file_put_contents("images/".$barber_image_name, base64_decode(explode(',',$barber_image)[1]));
    $final_url = APP_URL.'business/images/'.$barber_image_name;
  

	$stmt = $conn->prepare("SELECT * FROM barbers WHERE barber_id = :barber_id");
	$stmt->execute(array(':barber_id' => $barber_id));
	
	

	if($stmt->rowCount() == 1){
		$stmt = $conn->prepare("UPDATE barbers SET
        barber_name = :barber_name,	
        barber_image = :barber_image,	
        barber_exp = :barber_exp,	
        barber_cutting_type = :barber_cutting_type,	
        barber_best_in = :barber_best_in,	
        barber_login_id = :barber_login_id,	
        barber_password = :barber_password,	
        barber_payout = :barber_payout	
        WHERE barber_id = :barber_id ");
		$data = array(
		            ':barber_name' => $barber_name,
                    ':barber_image' => $final_url,
                    ':barber_exp' => $barber_exp,
                    ':barber_cutting_type' => $barber_cutting_type,
                    ':barber_best_in' => $barber_best_in,
                    ':barber_login_id' => $barber_login_id,
                    ':barber_password' => $barber_password,
                    ':barber_payout' => $barber_payout,
                    ':barber_id' => $barber_id);
		$stmt->execute($data);
		if($stmt->rowCount() == 1){
			echo json_encode(['response'=>'Barber details has been updated','code' => 200]);
		}else{
		    echo json_encode(['response'=>'Failed','code' => 401]);
		}
	}else{
		echo json_encode(['response'=>'Barber was not found','code' => 401]);
	}
    
}else{
    echo json_encode(['response'=>'Invalid Request','code' => 401]);
}