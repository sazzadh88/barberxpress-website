<?php
	require '../config/db.php';
	
	if(isset($_POST['user_id'])){
	    $user_id = $_POST['user_id'];
	    $stmt = $conn->prepare("SELECT bookings.*, business_partners.partner_display_name  from bookings LEFT JOIN business_partners 
	    ON business_partners.partner_id = bookings.partner_id
	    WHERE bookings.user_id = :user_id");
	    $stmt->execute([':user_id' => $user_id]);
	    
	    $data = [];
	    
	    function fetchBookingDetails($id){
	        global $conn;
	        $stmt4 = $conn->prepare("SELECT services.service_name,services.service_time,booking_data.* FROM booking_data LEFT JOIN services ON services.id = booking_data.service_id WHERE booking_id = :id");
	        $stmt4->execute(['id' => $id]);
	        $data = [];
	        while($row = $stmt4->fetchObject()){
	            $data[] = $row;
	        }
	        return $data;
	    }
	    
	    while($row = $stmt->fetchObject()){
	        $row->bookingDetails = fetchBookingDetails($row->id);
	        $data[] = $row;
	    }
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	}
	
	