<?php

require('../config/db.php');

if(isset($_POST['partner_id'],$_POST['user_id'],$_POST['rating_value'],$_POST['feedback'])){

	$partner_id = $_POST['partner_id'];
	$user_id = $_POST['user_id'];
	$rating_value = $_POST['rating_value'];
	$feedback = $_POST['feedback'];
	
	
	$stmt = $conn->prepare("INSERT INTO ratings(partner_id, user_id, rating_value,feedback) values(:partner_id, :user_id, :rating_value,:feedback)");
	$stmt->execute([
	        ':partner_id' => $partner_id, 
	        ':user_id' => $user_id, 
	        ':rating_value' => $rating_value,
	        ':feedback' => $feedback
	    ]);
	if($stmt->rowCount() == 1){
	    echo json_encode(['response'=>'Rating added', 'code' =>200]);
	}else{
	    echo json_encode(['response'=>'Error!', 'code' =>401]);
	}

    
}else{
    echo json_encode(['response'=>'Invalid Request', 'code' =>401]);
}