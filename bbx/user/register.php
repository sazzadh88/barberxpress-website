<?php

header("Content-type: application/json");

require('../config/db.php');
require('../config/func.php');



if(isset($_POST['mobile'],$_POST['sim_no'],$_POST['device_id'])){
    

    $sim_no = $_POST['sim_no'];
    $device_id = $_POST['device_id'];
    
    $stmt = $conn->prepare("SELECT * FROM devices WHERE sim_no = :sim_no OR device_id = :device_id");
    $stmt->execute([':sim_no' => $sim_no, ':device_id' => $device_id]);
    
    if($stmt->rowCount() >= 1){
        echo json_encode(['response'=>'You can\'t create multiple account in a single device','code' => 401]); exit;
    }
    
    
    $mobile = $_POST['mobile'];
	$otp = mt_rand(100000, 999999);

	$stmt = $conn->prepare("SELECT * FROM users WHERE user_mobile = :mobile");
	$stmt->execute(array(':mobile' => $mobile));
	$result = $stmt->fetchObject();
	$refcode = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10)); 
    
	if(empty($result)){
		$stmt = $conn->prepare("INSERT INTO users (user_mobile,user_otp,ref_code) VALUES(:mobile,:otp,:ref_code)");
		$data = array(
					':mobile'=>$mobile,
					':otp'=>$otp,
					':ref_code' => $refcode
				);
		$stmt->execute($data);
		$user_id = $conn->lastInsertId();
		if($stmt->rowCount() == 1){
		    $stmt = $conn->prepare("INSERT INTO wallets (wallet_id,user_mobile,wallet_amount) VALUES(:wallet_id,:user_mobile,:wallet_amount)");
		    $stmt->execute(array(':wallet_id' => NULL,':user_mobile' => $mobile,':wallet_amount' => 0.00));
		    if($stmt->rowCount() == 1){
    			$sms = (new Sms)->send($mobile,'Your verification code is: '.$otp);
    			
			 //   function getReferralAmount(){
                    
    //                 global $conn;
                    
    //                 $stmt = $conn->prepare("SELECT value FROM settings WHERE type ='REFERRAL_BONUS'");
    //                 $stmt->execute();
    //                 $data = $stmt->fetchObject();
    //                 return $data->value;
    //             }
                
    //             $referral_amount = getReferralAmount();
                
    //             if(isset($_POST['referral_user'])){
                    
    //                 if($_POST['referral_user'] == 1){
                        
    //                     $referred_by = $_POST['referred_by'];
    //                     $referred_mobile = $_POST['referred_mobile'];
    //                     $stmt = $conn->prepare("INSERT INTO wallet_transactions(user_id,type,description,amount) VALUES(:user_id,:type,:description,:amount)");
    //                     $stmt->execute([':user_id' => $referred_by,':type' => 'CREDIT',':description' => 'Referral Reward',':amount' => $referral_amount]);
    //                     if($stmt->rowCount() == 1){
                            
    //                         $stmt2 = $conn->prepare("UPDATE wallets SET wallet_amount = wallet_amount + ".$referral_amount." WHERE user_mobile = :user_mobile");
    //                         $stmt2->execute([':user_mobile' => $referred_mobile]);
                            
    //                         $stmt3 = $conn->prepare("INSERT INTO referrals (user_id,referred_by) VALUES(:user_id,:referred_by)");
    //                         $stmt3->execute([':user_id' => $user_id,':referred_by' => $referred_by]);
    //                     }
                        
    //                 }
    //             }

    			echo json_encode(['response'=>'Your verification code has been sent to mobile','code'=> 403]);
		    }else{
		        echo json_encode(['response'=>'Error while creating wallet. Please contact support.','code'=> 401]);
		    }
		
		}
	}else{
	    if($result->user_verified == 0){
	        $stmt = $conn->prepare("UPDATE users SET user_otp = :otp WHERE user_mobile = :mobile ");
	        $stmt->execute([':otp' => $otp, ':mobile' => $mobile]);
	        if($stmt->rowCount() == 1){
	            $sms = (new Sms)->send($mobile,'Your verification code is: '.$otp);
	            echo json_encode(['response'=>'Please verify your mobile number', 'code'=> 403]);
	        }else{
	            echo json_encode(['response'=>'Update Error', 'code'=> 401]);
	        }
	        
	        
	    }else{
	        echo json_encode(['response'=>'Mobile number is already registered','code' => 401]);
	    }
		
	}
    
}else{
    echo json_encode(['response'=>'Invalid Request','code' => 401]);
}