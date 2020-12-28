<?php

require('../config/db.php');


if(isset($_POST['partner_id'])){
    
	$partner_id = $_POST['partner_id'];
    $partner_mobile = $_POST['partner_mobile'];
    $partner_password = $_POST['partner_password'];
    $partner_email = $_POST['partner_email'];
    $partner_gstin = $_POST['partner_gstin'];
    $partner_specialization = $_POST['partner_specialization'];
    $partner_description = $_POST['partner_description'];
    $partner_pan = $_POST['partner_pan'];
    $partner_pan_name = $_POST['partner_pan_name'];
    $partner_category = $_POST['partner_category'];
    $partner_sub_category = $_POST['partner_sub_category'];
    $partner_bank_name = $_POST['partner_bank_name'];
    $partner_bank_account = $_POST['partner_bank_account'];
    $partner_bank_ifsc = $_POST['partner_bank_ifsc'];
    $saloon_seat_count = $_POST['saloon_seat_count'];
    $provides_home_service = $_POST['provides_home_service'];
    
    $saloon_img = $_POST['saloon_img'];
   
    $saloon_img_name = $partner_id .'-'. uniqid().".png";
    file_put_contents("images/".$saloon_img_name, base64_decode(explode(',',$saloon_img)[1]));
    $final_url = APP_URL.'business/images/'.$saloon_img_name;
  

	$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_id = :partner_id");
	$stmt->execute(array(':partner_id' => $partner_id));
	
	

	if($stmt->rowCount() == 1){
		$stmt = $conn->prepare("UPDATE business_partners SET
		partner_mobile = :partner_mobile,
        partner_password = :partner_password,
        partner_email = :partner_email,
        partner_gstin = :partner_gstin,
        partner_specialization = :partner_specialization,
        partner_description = :partner_description,
        partner_pan = :partner_pan,
        partner_pan_name = :partner_pan_name,
        partner_category = :partner_category,
        partner_sub_category = :partner_sub_category,
        partner_bank_name = :partner_bank_name,
        partner_bank_account = :partner_bank_account,
        partner_bank_ifsc = :partner_bank_ifsc,
        saloon_img = :saloon_img,
        saloon_seat_count = :saloon_seat_count,
        provides_home_service = :provides_home_service
        WHERE partner_id = :partner_id
		");
		$data = array(
		            ':partner_mobile' => $partner_mobile,
                    ':partner_password' => $partner_password,
                    ':partner_email' => $partner_email,
                    ':partner_gstin' => $partner_gstin,
                    ':partner_specialization' => $partner_specialization,
                    ':partner_description' => $partner_description,
                    ':partner_pan' => $partner_pan,
                    ':partner_pan_name' => $partner_pan_name,
                    ':partner_category' => $partner_category,
                    ':partner_sub_category' => $partner_sub_category,
                    ':partner_bank_name' => $partner_bank_name,
                    ':partner_bank_account' => $partner_bank_account,
                    ':partner_bank_ifsc' => $partner_bank_ifsc,
                    ':saloon_img' => $final_url,
                    ':saloon_seat_count' => $saloon_seat_count,
                    ':provides_home_service' => $provides_home_service,
                    ':partner_id' => $partner_id,
				);
		$stmt->execute($data);
		if($stmt->rowCount() == 1){
			echo json_encode(['response'=>'Profile setup successful','code' => 200]);
		}else{
		    echo json_encode(['response'=>'Profile setup failed','code' => 401]);
		}
	}else{
		echo json_encode(['response'=>'User was not found','code' => 401]);
	}
    
}else{
    echo json_encode(['response'=>'Invalid Request','code' => 401]);
}