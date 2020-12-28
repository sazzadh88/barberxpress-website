<?php

    require('../config/db.php');
    
    
    if(isset($_POST['parent_cat_id'],$_POST['sub_cat_name'])){
        
        $parent_cat_id = $_POST['parent_cat_id'];
        $sub_cat_name = $_POST['sub_cat_name'];
        
        
        $stmt = $conn->prepare("SELECT * FROM subcategories WHERE parent_cat_id = :parent_cat_id AND sub_cat_name = :sub_cat_name");
	    $stmt->execute(array(':parent_cat_id' => $parent_cat_id, ':sub_cat_name' => $sub_cat_name));
	    
	    if($stmt->rowCount() == 0){
	        
	       $stmt = $conn->prepare("INSERT INTO subcategories VALUES(:sub_cat_id,:parent_cat_id,:sub_cat_name)");
	       $stmt->execute(array(':sub_cat_id' => NULL,':parent_cat_id' => $parent_cat_id, ':sub_cat_name' => $sub_cat_name));
	       if($stmt->rowCount() == 1){
	           echo json_encode(['response'=>'Sub Category added successfully','code' => 200]); 
	       }else{
	           echo json_encode(['response'=>'Error','code' => 401]);
	       }
	    }else{
	        echo json_encode(['response'=>'Sub Category Exists','code' => 401]);
	    }
    }

?>