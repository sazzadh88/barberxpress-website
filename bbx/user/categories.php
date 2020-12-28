<?php
header("content-type:application/json");
require '../config/db.php';
	
	    function getSubCategories($conn, $cat_id){
	        $stmt = $conn->prepare("SELECT * FROM subcategories WHERE parent_cat_id = :cat_id");
	        $stmt->execute([':cat_id' => $cat_id]);
	        $data = [];
    	    while($row = $stmt->fetchObject()){
    	        $data[] = $row;
    	    }
    	    
    	    return is_null($data) ? [] : $data;
	    }
	
	    
	    $stmt = $conn->prepare("SELECT * FROM categories ORDER BY categories.cat_name ASC");
	    $stmt->execute();
	    while($row = $stmt->fetchObject()){
	        $row->subCategoryData = getSubCategories($conn, $row->cat_id);
	        $data[] = $row;
	    }
	   // if($data){
	   //     echo json_encode(['code' => 200 , 'data'=> is_null($data) ? [] : $data]);
	   // }else{
	   //     echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	   // }
	   
	   if (empty($data))
	   {
	       echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	   }
	   else
	   {
	       echo json_encode(['code' => 200 , 'data'=> is_null($data) ? [] : $data]);
	   }
	
	
	