<?php
	require '../config/db.php';

	if(isset($_POST['booking_id'],$_POST['payment_status'])){
	   
	    $payment_status = $_POST['payment_status'];
	    $booking_id = $_POST['booking_id'];
	    $order_status = 0;
	    
	    if($payment_status == 1){
	        $order_status = 1;
	    }
	    
	    
	    $stmt = $conn->prepare("UPDATE bookings SET payment_status = :payment_status, status = :order_status WHERE id = :id");
	    $stmt->execute([':payment_status' => $payment_status,':order_status' => $order_status,':id' => $booking_id ]);
	    
	 
       if($stmt->rowCount() == 1){
            echo json_encode(['response'=>'Booking Successful','code' => 200]); 
       }else{
           echo json_encode(['response'=>'Error','code' => 401]);
       }
	}else{
	    echo json_encode(['response'=>'Invalid Request','code' => 401]);
	}
	
	