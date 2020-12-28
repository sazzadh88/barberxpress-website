<?php
require('../config/db.php');
require('../config/func.php');
if(isset($_POST['partner_id'])){

    $partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT *  FROM merchant_payments WHERE partner_id = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data['settled'] = [];
    $data['unsettled'] = [];
    
    while($row = $stmt->fetchObject()){
        if($row->settled == 1){
            $data['settled'][] = $row;
        }else{
            $data['unsettled'][] = $row;
        }
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
    
    
}else{
    echo json_encode(['code' => 401, 'response' => "Invalid request"]);
}