<?php
	require '../config/db.php';
	
	    
	        if(isset($_POST['code'],$_POST['partner_id'])){
	            $code = $_POST['code'];
        	    $stmt = $conn->prepare("SELECT * from coupons WHERE code = :code AND DATE(expires_on) >= DATE(NOW())");
        	   // $stmt = $conn->prepare("SELECT * from coupons WHERE (code = :code AND partner_id = :partner_id) AND DATE(expires_on) >= DATE(NOW())");
        	    $stmt->execute([':code' => $code]);
        	    
        	    if($stmt->rowCount() >= 1){
        	        
        	        $row = $stmt->fetchObject();
            	    
            	    if($row){
            	        echo json_encode(['code' => 200 , 'data'=> $row,'response' => 'Coupon applied successfully']);
            	    }else{
            	        echo json_encode(['code' => 401 , 'response'=> 'Invalid/Expired coupon code']);
            	    }
        	    
        	    }else{
	                
	                $partner_id = $_POST['partner_id'];
    	            $code = $_POST['code'];
    	            
    	            $stmt = $conn->prepare("SELECT * from offers WHERE (code = :code AND partner_id = :partner_id) AND DATE(expires_on) >= DATE(NOW())");
            	    $stmt->execute([':code' => $code,':partner_id' => $partner_id]);
            	    
            	    $row = $stmt->fetchObject();
            	      
            	    if($row){
            	        echo json_encode(['code' => 200 , 'data'=> $row,'response' => 'Offer applied successfully']);
            	    }else{
            	        echo json_encode(['code' => 401 , 'response'=> 'Invalid offer code']);
            	    }
        	    }
    	    
	        }else{
	            echo json_encode(['code' => 401 , 'response'=> 'Invalid request']);
	        }
	   
	
	