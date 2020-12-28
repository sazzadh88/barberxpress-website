<?php
require('../config/db.php');


if(isset($_POST['partner_id'])){
    
    
    $partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT *  FROM memberships WHERE partner_id = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data = [];
    
    while($row = $stmt->fetchObject()){
        $data[] = $row;
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
    
    
}