<?php
require('../config/db.php');


if(isset($_POST['timeslot_id'],$_POST['booking_date'])){
    
        $timeslot_id = $_POST['timeslot_id'];
        $booking_date = $_POST['booking_date'];
        
        function isAvailable($inner_slot){
            global $conn,$booking_date;
            $stmt = $conn->prepare("SELECT * FROM bookings WHERE time_inner_id = :time_inner_id AND booking_date = :booking_date");
            $stmt->execute([':time_inner_id' => $inner_slot, ':booking_date' => $booking_date]);
            $stmt->fetchObject();
            if($stmt->rowCount() >= 1){
                return false;
            }else{
                return true;
            }
        }
 
        $stmtx = $conn->prepare("SELECT *, id as time_inner_id  FROM timeslot_inners WHERE timeslot_id = :timeslot_id");
        $stmtx->execute([':timeslot_id' => $timeslot_id]);
        $datax = [];
        
        while($rowx = $stmtx->fetchObject()){
            $rowx->is_available = isAvailable($rowx->id);
            $datax[] = $rowx;
        }
        
        
    

    if(empty($datax)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $datax]);
    }
    
    
    
    
}else{
     echo json_encode(['code' => 401, 'response' => "Invalid Request"]);
}