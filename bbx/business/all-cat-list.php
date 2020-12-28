<?php
require('../config/db.php');


if(isset($_POST['partner_id'])){
    
    
    function getSubCategory($parent_cat_id){
        global $conn;
        $stmt = $conn->prepare("SELECT *  FROM subcategories WHERE parent_cat_id = :parent_cat_id");
        $stmt->execute([':parent_cat_id' => $parent_cat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT *  FROM categories WHERE cat_owner = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data = [];
    
    while($row = $stmt->fetchObject()){
        $row->subCategories = getSubCategory($row->cat_id);
        $data[] = $row;
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
    
    
}