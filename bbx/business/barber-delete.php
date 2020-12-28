<?php
require('../config/db.php');


if(isset($_POST['barber_id'],$_POST['partner_id'])){
    
    
    $barber_id = $_POST['barber_id'];
    $partner_id = $_POST['partner_id'];
    
    $stmt = $conn->prepare("SELECT * FROM barbers WHERE partner_id = :partner_id AND barber_id = :barber_id");
    $stmt->execute([':barber_id' => $barber_id,'partner_id' => $partner_id]);
    
    if($stmt->rowCount() == 1){
        $stmt = $conn->prepare("DELETE FROM barbers WHERE barber_id = :barber_id");
        $stmt->execute([':barber_id' => $barber_id]);
        
        echo json_encode(['code' => 200, 'response' => "Deleted!"]);
    }else{
        echo json_encode(['code' => 401, 'response' => "Unable to process data"]);
    }  
}else{
    echo json_encode(['code' => 401, 'response' => "Invalid request"]);
}