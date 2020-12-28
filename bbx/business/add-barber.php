<?php

    require('../config/db.php');
    
    
    if(isset($_POST['partner_id'])){
        
        $partner_id = $_POST['partner_id'];
        $barber_name = $_POST['barber_name'];
        $barber_exp = $_POST['barber_exp'];
        $barber_image = $_POST['barber_image'];
        $barber_cutting_type = $_POST['barber_cutting_type'];
        $barber_best_in = $_POST['barber_best_in'];
        $barber_login_id = $_POST['barber_login_id'];
        $barber_password = $_POST['barber_password'];
        $barber_payout = $_POST['barber_payout'];
        
        
        $stmt = $conn->prepare("SELECT * FROM barbers WHERE partner_id = :partner_id AND barber_login_id = :barber_login_id");
	    $stmt->execute(array(':partner_id' => $partner_id, ':barber_login_id' => $barber_login_id));
	    
	    if($stmt->rowCount() == 0){
	        
	       //Image Conversion
	       $barber_image_enc = $partner_id .'-'. uniqid().".png";
           file_put_contents("images/".$barber_image_enc, base64_decode(explode(',',$barber_image)[1]));
	       
	       $stmt = $conn->prepare("INSERT INTO barbers VALUES(:barber_id,:partner_id,:barber_name,:barber_image,:barber_exp,:barber_cutting_type,:barber_best_in,:barber_login_id,:barber_password,:barber_payout,:barber_signup_date)");
	       $stmt->execute(array(':barber_id' => NULL,':partner_id' => $partner_id, ':barber_name' => $barber_name,':barber_image' => $barber_image_enc,':barber_exp' => $barber_exp,':barber_cutting_type' => $barber_cutting_type,':barber_best_in' => $barber_best_in,':barber_login_id' => $barber_login_id,':barber_password' => $barber_password,':barber_payout' => $barber_payout,':barber_signup_date'=>date('Y-m-d')));
	       if($stmt->rowCount() == 1){
	           echo json_encode(['response'=>'Barber added successfully','code' => 200]); 
	       }else{
	           echo json_encode(['response'=>'Error','code' => 401]);
	       }
	    }else{
	        echo json_encode(['response'=>'Barber Login ID exists','code' => 401]);
	    }
    }

?>