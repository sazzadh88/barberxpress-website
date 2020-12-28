<?php
header("content-type:application/json");
require('../config/db.php');


if(isset($_REQUEST['partner_id'])){
   
    
    $partner_id = $_REQUEST['partner_id'];
    $stmt = $conn->prepare("SELECT id,time_group  FROM timeslots WHERE partner_id = :partner_id");
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