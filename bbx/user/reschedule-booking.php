<?php
	require '../config/db.php';
	
	    if(isset($_POST['booking_id'],$_POST['user_id'],$_POST['booking_date'],$_POST['time_slot'],$_POST['time_inner'])){
            $booking_id = $_POST['booking_id'];
            $user_id = $_POST['user_id'];
            $booking_date = $_POST['booking_date'];
            $time_slot = $_POST['time_slot'];
            $time_inner = $_POST['time_inner'];
            
            $stmt = $conn->prepare("SELECT * from bookings WHERE id = :id AND user_id = :user_id");
            $stmt->execute([':id' => $booking_id, ':user_id' => $user_id]);
            // $data = $stmt->fetchObject();
            // print_r($data);
            // exit;
            if($stmt->rowCount() == 1){
                $stmt1 = $conn->prepare("UPDATE bookings SET booking_date = :booking_date, time_slot = :time_slot, time_inner = :time_inner  WHERE id = :id");
                $stmt1->execute([':id' => $booking_id,':booking_date' => $booking_date, ':time_inner' => $time_inner,':time_slot' => $time_slot]);
                if($stmt1->rowCount() == 1){
                    echo json_encode(['code' => 200 , 'response'=> 'Order has been re-scheduled']);
                }else{
                    echo json_encode(['code' => 401 , 'response'=> 'Already re-scheduled']);
                }
            }else{
                echo json_encode(['code' => 401 , 'response'=> 'Can not process your request']);
            }
            
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'Invalid request!']);
	    }
	
	
	