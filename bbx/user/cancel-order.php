<?php
	require '../config/db.php';
	
	    if(isset($_POST['booking_id'],$_POST['user_id'],$_POST['cancel_reason'])){
            $booking_id = $_POST['booking_id'];
            $user_id = $_POST['user_id'];
            $cancel_reason = $_POST['cancel_reason'];
            $stmt = $conn->prepare("SELECT * from bookings WHERE id = :id AND user_id = :user_id");
            $stmt->execute([':id' => $booking_id, ':user_id' => $user_id]);
            // $data = $stmt->fetchObject();
            // print_r($data);
            // exit;
            if($stmt->rowCount() == 1){
                $stmt1 = $conn->prepare("UPDATE bookings SET status = 4, cancel_reason = :cancel_reason WHERE id = :id");
                $stmt1->execute([':id' => $booking_id, ':cancel_reason' => $cancel_reason]);
                if($stmt1->rowCount() == 1){
                    echo json_encode(['code' => 200 , 'response'=> 'Order has been cancelled & your refund will be processed soon.']);
                }else{
                    echo json_encode(['code' => 401 , 'response'=> 'Already cancelled']);
                }
            }else{
                echo json_encode(['code' => 401 , 'response'=> 'Can not process your request']);
            }
            
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'Invalid request!']);
	    }
	
	
	