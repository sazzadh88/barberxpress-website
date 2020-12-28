<?php

require('../config/db.php');

if(isset($_POST['partner_id'])){
    
	$partner_id = $_POST['partner_id'];
	$wifi_available = $_POST['wifi_available'];
	$services = $_POST['services'];
	$department = $_POST['department'];
	$brands = $_POST['brands'];
	$working_day = $_POST['working_day'];
	$service_timing = $_POST['service_timing'];


	
	


	$stmt = $conn->prepare("INSERT INTO facilities (wifi_available,services,department,brands,working_day,service_timing,partner_id) VALUES(:wifi_available,:services,:department,:brands,:working_day,:service_timing,:partner_id)");
	
	$data = array(
				':partner_id'=> $partner_id,
				':wifi_available'=> $wifi_available,
				':services'=> $services,
				':department'=> $department,
				':brands'=> $brands,
				':working_day'=> $working_day,
				':service_timing'=> $service_timing,
			);
	
	$stmt->execute($data);
	
	if($stmt->rowCount() == 1){
		echo json_encode(['response'=>'Facility details has been added successfully','code' => 200]);
	}else{
	    echo json_encode(['response'=>'Failed','code' => 401]);
	}

    
}else{
    echo json_encode(['response'=>'Invalid Request','code' => 401]);
}