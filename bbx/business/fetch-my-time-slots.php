<?php
require('../config/db.php');


if(isset($_POST['partner_id'])){
    
    function getInnerData($timeslot_id){
        global $conn;
        $stmtx = $conn->prepare("SELECT *  FROM timeslot_inners WHERE timeslot_id = :timeslot_id");
        $stmtx->execute([':timeslot_id' => $timeslot_id]);
        $datax = [];
        
        while($rowx = $stmtx->fetchObject()){
            $datax[] = $rowx;
        }
        
        return $datax;
    }
    
    
    $partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT id,time_group  FROM timeslots WHERE partner_id = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data = [];
    
    while($row = $stmt->fetchObject()){
        $row->innerSlots = getInnerData($row->id);
        $data[] = $row;
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
    
    
    
    
}