<?php
require('../config/db.php');


if(isset($_POST['membership_id'],$_POST['partner_id'])){
    
    
    $membership_id = $_POST['membership_id'];
    $partner_id = $_POST['partner_id'];
    
    $stmt = $conn->prepare("SELECT * FROM memberships WHERE partner_id = :partner_id AND id = :id");
    $stmt->execute([':id' => $membership_id,'partner_id' => $partner_id]);
    
    if($stmt->rowCount() == 1){
        $stmt = $conn->prepare("DELETE FROM memberships WHERE id = :id");
        $stmt->execute([':id' => $membership_id]);
        
        echo json_encode(['code' => 200, 'response' => "Deleted!"]);
    }else{
        echo json_encode(['code' => 401, 'response' => "Unable to process data"]);
    }  
}else{
    echo json_encode(['code' => 401, 'response' => "Invalid request"]);
}