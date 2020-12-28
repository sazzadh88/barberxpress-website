<?php
	require '../config/db.php';
	
	
	    if(isset($_GET['filter'])){
	        
	        $category = $_GET['filter'];
	        $stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_category LIKE :filter AND 
	        (partner_otp_verified = 1 AND partner_profile_verified =1)");
	        $stmt->execute([':filter' => '%'.$category.'%']);
	        $data = [];
	        while($row = $stmt->fetchObject()){
	            $data[] = $row;
	        }
	        
	        if(empty($data)){
			    echo json_encode(['code' => 401 , 'response' => 'Nothing Found']);
    		}else{
    		    echo json_encode(['code' => 200 , 'response'=>'Success','data' => $data]);
    		}
    		
    		exit;
	        
	        
	    }
      
		$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_otp_verified = 1 AND partner_profile_verified =1");
		$stmt->execute();
		$data = [];
		while($result = $stmt->fetchObject()){
		 
		    $data[] = $result;
		}
		
    	$popular_salon = [];
    	foreach($data as $d){
    	    if($d->is_popular == 1){
    	        $popular_salon[] = $d;
    	    }
    	}
		
		if(empty($data)){
			echo json_encode(['code' => 401 , 'response' => 'Nothing Found']);
		}else{
		    echo json_encode(['code' => 200 , 'response'=>'Success','data' => $data, 'popular_salon' => $popular_salon]);
		}
		
		
