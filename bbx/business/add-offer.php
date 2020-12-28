<?php

    require('../config/db.php');
    
    
    if(isset($_POST['partner_id'])){
        
        $partner_id = $_POST['partner_id'];
        $title = $_POST['title'];
        $code = $_POST['code'];
        $description = $_POST['description'];
       
        $value = $_POST['value'];
        $terms = $_POST['terms'];
        $created_at = date('Y-m-d');
        $expires_on = $_POST['expires_on'];
        $banner = $_POST['banner'];
        
        
        $stmt = $conn->prepare("SELECT * FROM offers WHERE code = :code");
	    $stmt->execute(array(':code' => $code));
	    
	    if($stmt->rowCount() == 0){
	        
	        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = :code");
	        $stmt->execute(array(':code' => $code));

	        if($stmt->rowCount() >= 1){
	             echo json_encode(['response'=>'Code exists','code' => 401]);
	        }else{
	            //Image Conversion
    	       $offer_image_enc = $partner_id .'-'. uniqid().".png";
               file_put_contents("images/".$offer_image_enc, base64_decode(explode(',',$banner)[1]));
    	       $final_url = APP_URL.'business/images/'.$offer_image_enc;
    	       $stmt = $conn->prepare("INSERT INTO offers VALUES(:id, :partner_id,:title,:code,:description,:banner,:value,:terms,:created_at,:expires_on)");
    	       $stmt->execute(array(':id' => null,':partner_id' => $partner_id,':title' => $title, ':code' => $code,':description' => $description,':banner' => $final_url,':value' => $value,':terms' => $terms,':created_at' => $created_at,':expires_on' => $expires_on));
    	       if($stmt->rowCount() == 1){
    	           echo json_encode(['response'=>'Offer added successfully','code' => 200]); 
    	       }else{
    	           echo json_encode(['response'=>'Error','code' => 401]);
    	       }
	        }
	        
	       
	    }else{
	        echo json_encode(['response'=>'Offer code exists','code' => 401]);
	    }
    }else{
        echo json_encode(['response'=>'Invalid Request','code' => 401]);
    }

?>