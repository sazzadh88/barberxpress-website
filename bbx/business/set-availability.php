<?php
	require '../config/db.php';

	if(isset($_POST['available'],$_POST['merchant_id'])){
	   
	    $available = $_POST['available'];
	    $merchant_id = $_POST['merchant_id'];
	    
	    $stmt = $conn->prepare("UPDATE business_partners SET available = :available WHERE merchant_id = :merchant_id");
	    $stmt->execute([':available' => $available,':merchant_id' => $merchant_id ]);
	    
	 
       if($stmt->rowCount() == 1){
            echo json_encode(['response'=>'Updated!','code' => 200]); 
       }else{
           echo json_encode(['response'=>'Error','code' => 401]);
       }
	}else{
	    echo json_encode(['response'=>'Invalid Request','code' => 401]);
	}
	
	