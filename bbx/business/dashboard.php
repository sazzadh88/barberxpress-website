<?php
require('../config/db.php');
require('../config/func.php');
if(isset($_POST['partner_id'])){
    $partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT *,(SELECT count(*)  FROM barbers WHERE partner_id = :partner_id) as babrber_count FROM business_partners WHERE partner_id = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data = $stmt->fetchObject();
    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'User was not found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
}