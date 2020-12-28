<?php

require('../config/db.php');

if(isset($_POST['booking_id'],$_POST['barber_id'])){
    $booking_id = $_POST['booking_id'];
    $barber_id = $_POST['barber_id'];
    
    $stmt = $conn->prepare("UPDATE bookings SET status = 3 WHERE id = :booking_id AND assigned_barber = :assigned_barber");
    $stmt->execute([':booking_id' => $booking_id, 'assigned_barber' => $barber_id]);
    if($stmt->rowCount() == 1){
        echo json_encode(['code' => 200, 'response' => 'Order has been completed']);
    }else{
        echo json_encode(['code' => 401, 'response' => 'Error']);
    }
    
}else{
     echo json_encode(['code' => 401, 'response' => 'Invalid Request']);
}

?>