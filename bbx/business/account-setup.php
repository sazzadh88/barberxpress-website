<?php

require('../config/db.php');



if(isset($_POST['partner_id'])){
    
    $service_category = json_decode($_POST['service_category']);
    $partner_id = $_POST['partner_id'];
    
    $stmt = $conn->prepare("DELETE FROM merchant_services WHERE business_partner_id = :business_partner_id");
    $stmt->execute(array(':business_partner_id' => $partner_id));
    
    foreach($service_category as $c)
    {
        $stmt = $conn->prepare("INSERT INTO merchant_services (business_partner_id, category_id) VALUES (:business_partner_id, :category_id)");
	    $stmt->execute(array(':business_partner_id' => $partner_id, ':category_id' => $c));
    }
    
   
    

    
	
    $partner_gstin = $_POST['partner_gstin'];
    $partner_address = $_POST['partner_address'];
    $partner_specialization = $_POST['partner_specialization'];
    $partner_pan = $_POST['partner_pan'];
    $partner_pan_name = $_POST['partner_pan_name'];
    $partner_display_name = $_POST['partner_display_name'];
    $partner_category = $_POST['partner_category'];
    $partner_sub_category = $_POST['partner_sub_category'];
    $partner_bank_account = $_POST['partner_bank_account'];
    $partner_bank_ifsc = $_POST['partner_bank_ifsc'];
    $partner_bank_name = $_POST['partner_bank_name'];
    $saloon_lat = $_POST['saloon_lat'];
    $saloon_lon = $_POST['saloon_lon'];
    $saloon_seat_count = $_POST['saloon_seat_count'];
    $provides_home_service = $_POST['provides_home_service'];
    $description = $_POST['description'];
    
    $saloon_img = $_POST['saloon_img'];
   
    $saloon_img_name = $partner_id .'-'. uniqid().".png";
    file_put_contents("images/".$saloon_img_name, base64_decode(explode(',',$saloon_img)[1]));
    $final_url = APP_URL.'business/images/'.$saloon_img_name;
	

	$stmt = $conn->prepare("SELECT * FROM business_partners WHERE partner_id = :partner_id");
	$stmt->execute(array(':partner_id' => $partner_id));
	
	

	if($stmt->rowCount() == 1){
		$stmt = $conn->prepare("UPDATE business_partners SET
		partner_gstin = :partner_gstin,
        partner_address = :partner_address,
        partner_specialization = :partner_specialization,
        partner_pan = :partner_pan,
        partner_pan_name = :partner_pan_name,
        partner_display_name = :partner_display_name,
        partner_category = :partner_category,
        partner_sub_category = :partner_sub_category,
        partner_bank_account = :partner_bank_account,
        partner_bank_ifsc = :partner_bank_ifsc,
        saloon_lat = :saloon_lat,
        partner_bank_name = :partner_bank_name,
        saloon_lon = :saloon_lon,
        saloon_seat_count = :saloon_seat_count,
        provides_home_service = :provides_home_service,
        partner_description = :partner_description,
        saloon_img = :saloon_img
        WHERE partner_id = :partner_id
		");
		$data = array(
		            ':partner_id' => $partner_id,
					':partner_gstin' => $partner_gstin,
                    ':partner_address' => $partner_address,
                    ':partner_specialization' => $partner_specialization,
                    ':partner_pan' => $partner_pan,
                    ':partner_pan_name' => $partner_pan_name,
                    ':partner_display_name' => $partner_display_name,
                    ':partner_category' => $partner_category,
                    ':partner_sub_category' => $partner_sub_category,
                    ':partner_bank_account' => $partner_bank_account,
                    ':partner_bank_name' => $partner_bank_name,
                    ':saloon_lat' => $saloon_lat,
                    ':saloon_lon' => $saloon_lon,
                    ':saloon_img' => $final_url,
                    ':provides_home_service' => $provides_home_service,
                    ':saloon_seat_count' => $saloon_seat_count,
                    ':partner_bank_ifsc' => $partner_bank_ifsc,
                    ':partner_description' => $description
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