<?php

require '../config/db.php';




if(isset($_POST['user_id'])){
    
     $user_id = $_POST['user_id'];
    
    $stmt = $conn->prepare("SELECT * FROM wallet_transactions WHERE user_id = :user_id AND (expires_on >= CURDATE() OR expires_on IS NULL)");
    $stmt->execute([':user_id' => $user_id]);
    $cash_data['bbx_cash'] = 0;
    $cash_data['bbx_cash_plus'] = 0;
    
    while($row = $stmt->fetchObject()){
       if($row->cash_type == 'CASH'){
           $cash_data['bbx_cash'] += $row->amount;
       }else{
           $cash_data['bbx_cash_plus'] += $row->amount;
       }
    }

   
    $stmt = $conn->prepare("SELECT user_memberships.usage_limit as limit_left,user_memberships.*,memberships.* FROM user_memberships 
                        LEFT JOIN memberships ON memberships.id = user_memberships.membership_id
                        WHERE user_memberships.user_id = :user_id AND user_memberships.to_date >= NOW() AND user_memberships.usage_limit <> 0");
    $stmt->execute([':user_id' => $user_id]);
    $data = $stmt->fetchObject();
    if($data){
        echo json_encode(['code' => 200, 'response' => $data, 'cash_data' => $cash_data]);
    }else{
        echo json_encode(['code' => 401, 'response' => 'Membership expired', 'cash_data' => $cash_data]); 
    }
}else{
     echo json_encode(['code' => 401, 'response' => 'Invalid Request']);
}
