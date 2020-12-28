<?php

require '../config/db.php';



if(isset($_POST['response'],$_POST['data'],$_POST['membership_id'],$_POST['membership_validity'],$_POST['user_id'],$_POST['usage_limit'])){
    
    if($_POST['response'] == 'success'){
        
        $data = explode(":", $_POST['data']);
        
        $orderId =  substr($data['1'],8);
        $paymentId =  substr($data['3'],10);
        $validity = $_POST['membership_validity'];
        $from_date = date("Y-m-d");
        $user_id = $_POST['user_id'];
        $to_date = date('Y-m-d', strtotime($from_date. ' + '.$validity.' days'));
        $membership_id = $_POST['membership_id'];
        $usage_limit = $_POST['usage_limit'];
        
        $stmt = $conn->prepare("INSERT INTO membership_payments (membership_id,user_id,orderId,paymentId) VALUES(:membership_id, :user_id, :orderId,:paymentId)");
        $stmt->execute([':membership_id' => $membership_id,':user_id' => $user_id, ':orderId' => $orderId,':paymentId' => $paymentId]);
        if($stmt->rowCount() == 1){
            
            $stmt2 = $conn->prepare("INSERT INTO user_memberships(user_id,membership_id,from_date,to_date,usage_limit) VALUES(:user_id,:membership_id,:from_date,:to_date,:usage_limit)");
            $stmt2->execute([':user_id' => $user_id,':membership_id' => $membership_id,':from_date' => $from_date,':to_date' => $to_date,':usage_limit' => $usage_limit]);
            if($stmt2->rowCount() == 1){
                echo json_encode(['response'=>'Successfully subscribed to membership','code' => 200]);
            }else{
                echo json_encode(['response'=>'Data can not be processed','code' => 401]);
            }
            
        }else{
            echo json_encode(['response'=>'Error!','code' => 401]);
        }
        
    }else{
        echo json_encode(['response'=>'Payment Failed','code' => 401]);
    }
}