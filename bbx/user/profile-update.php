<?php

require('../config/db.php');

if(isset($_POST['name'],$_POST['email'],$_POST['mobile'],$_POST['password'],$_POST['user_id'])){
    
   

	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password = $_POST['password'];
	$user_id = $_POST['user_id'];

	$stmt = $conn->prepare("SELECT * FROM users WHERE user_mobile = :mobile");
	$stmt->execute(array(':mobile' => $mobile));
	$result = $stmt->fetchObject();

	if(!empty($result)){
		$stmt = $conn->prepare("UPDATE users SET user_name = :name ,user_email = :email, user_password =:password WHERE user_mobile = :mobile");
	
		$stmt->execute([':name'=>$name,':email'=>$email,':mobile'=>$mobile,':password'=>$password]);
		if($stmt->rowCount() == 1){
		    
		    if(isset($_POST['referral_user'])){
                    
                if($_POST['referral_user'] == 1){
                    $referred_by = $_POST['referred_by'];
                    $stmt3 = $conn->prepare("INSERT INTO referrals (user_id,referred_by) VALUES(:user_id,:referred_by)");
                    $stmt3->execute([':user_id' => $user_id,':referred_by' => $referred_by]);
                }
            }
             echo json_encode(['response'=>'Profile has been updated', 'code' => 200]);   
		}else{
		    echo json_encode(['response'=>'Error', 'code' =>401]);
		}
		
	}else{
		echo json_encode(['response'=>'Profile was not found', 'code' => 401]);
	}
    
}else{
    echo json_encode(['response'=>'Invalid Request', 'code' =>401]);
}