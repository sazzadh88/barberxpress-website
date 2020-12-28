<?php
	require '../config/db.php';
	
	if(isset($_POST['user_id'])){

        $user_id = $_POST['user_id'];
        
        if($_GET['cart_id']){
            
            $cart_id = $_GET['cart_id'];
            $stmt = $conn->prepare("DELETE FROM carts WHERE cart_id = :cart_id");
    	    $stmt->execute([':cart_id' => $cart_id]);
    	    echo json_encode(['code' => 200 , 'response'=> 'Deleted']);
    	    exit;
        }
        
        $stmt = $conn->prepare("DELETE FROM carts WHERE user_id = :user_id");
	    $stmt->execute([':user_id' => $user_id]);
	    echo json_encode(['code' => 200 , 'response'=> 'Cart has been cleared']);
	
	}else{
	    echo json_encode(['code' => 401 , 'response'=> 'Invalid request']);
	}
	
	   
	    
	