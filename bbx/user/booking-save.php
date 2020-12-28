<?php
	require '../config/db.php';

	if(isset($_POST['coupon_code'],$_POST['coupon_code_discount'],$_POST['membership_booking'],
	$_POST['discounted_price'],$_POST['discount_percentage'],$_POST['user_id'],$_POST['final_amount'],
	$_POST['booking_data'],$_POST['partner_id'],$_POST['time_slot'],$_POST['time_inner'],$_POST['time_inner_id'],
	$_POST['booking_date'],$_POST['home_service'],$_POST['service_address'],$_POST['user_mobile'])){
	   
	    $booking_data = json_decode($_POST['booking_data'], true);
	    $str =  "BBX-".date('dHis') . $_POST['user_id'];
        $booking_ref = str_pad($str, 17, "0", STR_PAD_RIGHT);
	    $final_amount = $_POST['final_amount'];
	    $user_id = $_POST['user_id'];
	    $booking_date = $_POST['booking_date'];
	    $home_service = $_POST['home_service'];
	    $service_address = $_POST['service_address'];
	    $membership_booking = $_POST['membership_booking'];
	    $discounted_price = $_POST['discounted_price'];
	    $discount_percentage = $_POST['discount_percentage'];
	    $coupon_code = $_POST['coupon_code'];
	    $coupon_code_discount = $_POST['coupon_code_discount'];
	    $time_inner_id = $_POST['time_inner_id'];
	    $user_mobile = $_POST['user_mobile'];
	    
	    $bbx_cash = $_POST['bbx_cash'];
	    $bbx_cash_plus = $_POST['bbx_cash_plus'];
	    $bbx_cash_plus_value = $_POST['bbx_cash_plus_value'];
	    $bbx_cash_value = $_POST['bbx_cash_value'];
	    
	    
	    $partner_id = $_POST['partner_id'];
	    $time_slot = $_POST['time_slot'];
	    $time_inner = $_POST['time_inner'];
	    
	    
	    
	    function fetchBookingDetails($id){
	        global $conn;
	        $stmt4 = $conn->prepare("SELECT services.service_name,booking_data.* FROM booking_data LEFT JOIN services ON services.id = booking_data.service_id WHERE booking_id = :id");
	        $stmt4->execute(['id' => $id]);
	        $data = [];
	        while($row = $stmt4->fetchObject()){
	            $data[] = $row;
	        }
	        return $data;
	    }
	    
	    function getReferredUser($user_id){
	        
	        global $conn;
	        
	        $stmt = $conn->prepare("SELECT referred_by FROM referrals WHERE user_id = :user_id");
	        $stmt->execute([':user_id' => $user_id]);
	        $data = $stmt->fetchObject();
	        
	        return $data;
	        
	    }
	    
	    $stmt = $conn->prepare("INSERT INTO bookings (bbx_cash_value, bbx_cash_plus_value,bbx_cash,bbx_cash_plus,booking_ref,user_id,final_amount,partner_id,time_slot,time_inner,booking_date,home_service,service_address,discount_percentage,discounted_price,membership_booking,coupon_code_discount,coupon_code,time_inner_id) 
	                            VALUES(:bbx_cash_value,:bbx_cash_plus_value,:bbx_cash,:bbx_cash_plus,:booking_ref,:user_id,:final_amount,:partner_id,:time_slot,:time_inner,:booking_date,:home_service,:service_address,:discount_percentage,:discounted_price,:membership_booking,:coupon_code_discount,:coupon_code,:time_inner_id)");
	    $stmt->execute([':bbx_cash_value' => $bbx_cash_value,':bbx_cash_plus_value' => $bbx_cash_plus_value,':bbx_cash_plus' => $bbx_cash_plus,':bbx_cash' => $bbx_cash,':service_address' => $service_address,':home_service' => $home_service,':booking_date' => $booking_date,
	    ':booking_ref' => $booking_ref,':user_id' => $user_id,':final_amount' => $final_amount, ':partner_id' => $partner_id,
	    ':time_slot' => $time_slot, ':time_inner' => $time_inner,':discount_percentage' => $discount_percentage,':discounted_price' => $discounted_price,
	    ':membership_booking' => $membership_booking,':coupon_code_discount' => $coupon_code_discount,':coupon_code' => $coupon_code, ':time_inner_id' => $time_inner_id ]);
	    
	   
       if($stmt->rowCount() == 1){
           $booking_id = $conn->lastInsertId();
           
           foreach($booking_data as $bk){
	            $stmt2 = $conn->prepare("INSERT INTO booking_data(booking_id,service_id,service_price) VALUES(:booking_id,:service_id,:service_price)");
	            $stmt2->execute(array(':booking_id' => $booking_id ,':service_id' => $bk['service_id'],':service_price' => $bk['service_price']));
            }
            
            $stmt3 = $conn->prepare("SELECT * FROM bookings WHERE id = :id");
            $stmt3->execute([':id' => $booking_id]);
            $data = $stmt3->fetchObject();
            $data->bookingDetails = fetchBookingDetails($data->id);
            
            //user_memberships
            if($membership_booking == 1){
                $stmt4 = $conn->prepare("UPDATE user_memberships SET usage_limit = GREATEST(0, usage_limit - 1) WHERE user_id = :user_id");
                $stmt4->execute(['user_id' => $user_id]);
            }
            
            $referred_user = getReferredUser($user_id);
            
            if($referred_user){
                function getReferralAmount(){
                    
                    global $conn;
                    
                    $stmt = $conn->prepare("SELECT value FROM settings WHERE type ='REFERRAL_BONUS'");
                    $stmt->execute();
                    $data = $stmt->fetchObject();
                    return $data->value;
                }
                
                $referral_amount = getReferralAmount();
                $referred_user_id = $referred_user->referred_by;
                
                $stmt = $conn->prepare("INSERT INTO wallet_transactions(user_id,cash_type,type,description,amount,expires_on) VALUES(:user_id,:cash_type,:type,:description,:amount,:expires_on)");
                $stmt->execute([':user_id' => $referred_user_id,':cash_type' => 'CASH_PLUS',':type' => 'CREDIT',':description' => 'Referral Reward for '.$user_mobile ,':amount' => $referral_amount,':expires_on' => date('Y-m-d',strtotime('+30 days',strtotime(date('Y-m-d')))) ]);
                
                if($bbx_cash == 'Yes'){
                    $stmt = $conn->prepare("INSERT INTO wallet_transactions(user_id,cash_type,type,description,amount) VALUES(:user_id,:cash_type,:type,:description,:amount)");
                    $stmt->execute([':user_id' => $user_id, ':cash_type' => 'CASH',':type' => 'DEBIT',':description' => 'For Booking ID: '.$booking_ref ,':amount' => $bbx_cash_value ]);
                }
                
                if($bbx_cash_plus == 'Yes'){
                    $stmt = $conn->prepare("INSERT INTO wallet_transactions(user_id,cash_type,type,description,amount) VALUES(:user_id,:cash_type,:type,:description,:amount)");
                    $stmt->execute([':user_id' => $user_id, ':cash_type' => 'CASH_PLUS',':type' => 'DEBIT',':description' => 'For Booking ID: '.$booking_ref,':amount' => $bbx_cash_plus_value ]);
                }
                
                
            }
            
            // exit;
            
            
            echo json_encode(['response'=>'Booking Successfull','code' => 200, 'booking_id' => $booking_id,'current_booking' => $data]); 
       }else{
           echo json_encode(['response'=>'Error','code' => 401]);
       }
	}else{
	    echo json_encode(['response'=>'Invalid Request','code' => 401]);
	}
	
	