<?php
header("content-type:application/json");
require '../config/db.php';
    
    if(isset($_GET['cat_owner'])){
        $cat_owner = $_GET['cat_owner'];
    }else{
        echo json_encode(["error" => "404! Not found"]);
        exit;
    }
	
	    function getSubCategories($conn, $cat_id){
	        $stmt = $conn->prepare("SELECT * FROM subcategories WHERE parent_cat_id = :cat_id");
	        $stmt->execute([':cat_id' => $cat_id]);
	        $data = [];
    	    while($row = $stmt->fetchObject()){
    	        $data[] = $row;
    	    }
    	    
    	    return is_null($data) ? [] : $data;
	    }
	
	    
	    $stmt = $conn->prepare("SELECT * FROM categories WHERE cat_owner = :cat_owner ORDER BY categories.cat_name ASC");
	    $stmt->execute([':cat_owner' => $cat_owner]);
	    
	    while($row = $stmt->fetchObject()){
	        $row->subCategoryData = getSubCategories($conn, $row->cat_id);
	        $data[] = $row;
	    }
	 
	   
	   if (empty($data))
	   {
	       echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	   }
	   else
	   {
	       echo json_encode(['code' => 200 , 'data'=> is_null($data) ? [] : $data]);
	   }
	
	
	