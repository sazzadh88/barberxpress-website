<?php

require '../config/db.php';

if(isset($_POST['response'],$_POST['data'],$_POST['booking_id'])){
    
    if($_POST['response'] == 'success'){
        $data = explode(":", $_POST['data']);
        
        $orderId =  substr($data['1'],8);
        $paymentId =  substr($data['3'],10);
        $booking_id = $_POST['booking_id'];
        
        $stmt = $conn->prepare("INSERT INTO payments (orderId,paymentId,booking_id) VALUES(:orderId, :paymentId, :booking_id)");
        $stmt->execute([':orderId' => $orderId,':paymentId' => $paymentId, ':booking_id' => $booking_id]);
        if($stmt->rowCount() == 1){
            $stmt2  = $conn->prepare("UPDATE bookings SET payment_status = 1 WHERE id = :id");
            $stmt2->execute([':id' => $booking_id ]);
            echo json_encode(['response'=>'Payment Successful','code' => 200]);
        }else{
            echo json_encode(['response'=>'Error!','code' => 401]);
        }
        
    }else{
        $stmt = $conn->prepare("UPDATE bookings SET payment_status = 2 WHERE id = :id");
        $stmt->execute([':id' => $booking_id ]);
        echo json_encode(['response'=>'Payment Failed','code' => 401]);
    }
}