<?php
require('../config/db.php');


if(isset($_POST['partner_id'],$_POST['cat_id'])){
    
    
    $partner_id = $_POST['partner_id'];
    $cat_id = $_POST['cat_id'];
    $stmt = $conn->prepare("SELECT *  FROM services 
                JOIN categories on categories.cat_id = services.category
                JOIN subcategories on subcategories.sub_cat_id = services.sub_category
                WHERE services.partner_id = :partner_id AND categories.cat_id = :cat_id");
    $stmt->execute([':partner_id' => $partner_id, ':cat_id' => $cat_id]);
    
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