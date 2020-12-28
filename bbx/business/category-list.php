<?php
header("content-type:application/json");
require('../config/db.php');


if(isset($_REQUEST['partner_id'])){
    
    
    
    function getSubCategory($cat_id){
        global $conn;
        $stmtx = $conn->prepare("SELECT *  FROM subcategories WHERE parent_cat_id = :parent_cat_id");
        $stmtx->execute([':parent_cat_id' => $cat_id]);
        $datax = [];
        
        while($rowx = $stmtx->fetchObject()){
            $datax[] = $rowx;
        }
        
        return $datax;
    }
    
    $partner_id = $_REQUEST['partner_id'];
    $stmt = $conn->prepare("SELECT *  FROM categories WHERE cat_owner = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data = [];
    
    while($row = $stmt->fetchObject()){
        $row->subCategoryData = getSubCategory($row->cat_id);
        $data[] = $row;
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
    
    
    
    
}