<?php

    require('../config/db.php');
    
    
    if(isset($_POST['partner_id'],$_POST['cat_name'],$_POST['image'])){
        
        $partner_id = $_POST['partner_id'];
        $cat_name = $_POST['cat_name'];
        $image = $_POST['image'];
        
        
        $stmt = $conn->prepare("SELECT * FROM categories WHERE cat_owner = :cat_owner AND cat_name = :cat_name");
	    $stmt->execute(array(':cat_owner' => $partner_id, ':cat_name' => $cat_name));
	    
	    if($stmt->rowCount() == 0){
	        
	       $stmt = $conn->prepare("INSERT INTO categories VALUES(:cat_id,:cat_name,:image,:cat_owner)");
	       $stmt->execute(array(':cat_id' => NULL,':cat_name' => $cat_name,':image' => $image ,':cat_owner' => $partner_id));
	       if($stmt->rowCount() == 1){
	           echo json_encode(['response'=>'Category added successfully','code' => 200]); 
	       }else{
	           echo json_encode(['response'=>'Error','code' => 401]);
	       }
	    }else{
	        echo json_encode(['response'=>'Category Exists','code' => 401]);
	    }
    }

?>