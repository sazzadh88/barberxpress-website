<?php
require('../config/db.php');


if(isset($_POST['service_id'],$_POST['partner_id'])){
    
    
    $service_id = $_POST['service_id'];
    $partner_id = $_POST['partner_id'];
    
    $stmt = $conn->prepare("SELECT * FROM services WHERE partner_id = :partner_id AND id = :service_id");
    $stmt->execute([':service_id' => $service_id,'partner_id' => $partner_id]);
    
    if($stmt->rowCount() == 1){
        $stmt = $conn->prepare("DELETE FROM services WHERE id = :id");
        $stmt->execute([':id' => $service_id]);
        
        echo json_encode(['code' => 200, 'response' => "Deleted!"]);
    }else{
        echo json_encode(['code' => 401, 'response' => "Unable to process data"]);
    }  
}else{
    echo json_encode(['code' => 401, 'response' => "Invalid request"]);
}