<?php
require('../config/db.php');


if(isset($_POST['parent_cat_id'])){
    
    
    $parent_cat_id = $_POST['parent_cat_id'];
    $stmt = $conn->prepare("SELECT *  FROM subcategories WHERE parent_cat_id = :parent_cat_id");
    $stmt->execute([':parent_cat_id' => $parent_cat_id]);
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