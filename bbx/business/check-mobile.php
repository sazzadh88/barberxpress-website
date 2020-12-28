<?php
require('../config/db.php');
require('../config/func.php');
if(isset($_POST['mobile'])){
    $mobile = $_POST['mobile'];
    $stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_mobile = :mobile");
    $stmt->execute([':mobile' => $mobile]);
    $data = $stmt->fetchObject();
    if(empty($data)){
        echo json_encode(['code' => 403, 'response' => 'User was not found']);
    }else{
        if($data->partner_otp_verified == 0){
            $otp = mt_rand(111111,999999);
            $stmt = $conn->prepare("UPDATE business_partners SET partner_otp = :otp WHERE partner_mobile = :mobile");
            $stmt->execute([':otp' => $otp,':mobile' => $mobile]);
            if($stmt->rowCount() == 1){
                (new Sms)->send($mobile, 'OTP for profile verification is: '.$otp);
                echo json_encode(['code' => 403, 'response' => 'OTP Verification is pending']);
            }else{
                echo json_encode(['code' => 401, 'response' => 'OTP update error']);
            }
        }else{
            echo json_encode(['code' => 200, 'response' => 'Sending to sign in page']);
        }
    }
}