<?php
	require '../config/db.php';
	
	if(isset($_POST['barber_id'])){
	    $barber_id = $_POST['barber_id'];
	    $stmt = $conn->prepare("SELECT users.user_name,bookings.* from bookings LEFT JOIN users ON users.user_id = bookings.user_id WHERE bookings.assigned_barber = :barber_id");
	    $stmt->execute([':barber_id' => $barber_id]);
	    
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
	    
	    function getBookingCount($user_id,$partner_id){
	        global $conn;
	        $stmt5 = $conn->prepare("SELECT count(*) as user_visit_count FROM bookings WHERE user_id = :user_id AND partner_id = :partner_id");
	        $stmt5->execute([':partner_id' => $partner_id, ':user_id' => $user_id]);
	        $data = $stmt5->fetchObject();
	        return $data->user_visit_count;
	        
	    }
	    
	    while($row = $stmt->fetchObject()){
	        $row->user_visit_count = getBookingCount($row->user_id, $row->partner_id);
	        $row->bookingDetails = fetchBookingDetails($row->id);
	        $data[] = $row;
	    }
	    if($data){
	        echo json_encode(['code' => 200 , 'data'=> $data]);
	    }else{
	        echo json_encode(['code' => 401 , 'response'=> 'No data found']);
	    }
	}
	
	