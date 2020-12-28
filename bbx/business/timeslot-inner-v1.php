<?php

    require('../config/db.php');
    
    
    if(isset($_POST['timeslot_id'],$_POST['timeslot_inner_times'])){
        
        $timeslot_id = $_POST['timeslot_id'];
        $timeslot_times = json_decode($_POST['timeslot_inner_times'], true);
	    
	    
        $stmt = $conn->prepare("DELETE FROM timeslot_inners WHERE timeslot_id = :timeslot_id");
        $stmt->execute([':timeslot_id' => $timeslot_id]);
        
        foreach($timeslot_times as $time){
                $stmt2 = $conn->prepare("INSERT INTO timeslot_inners (timeslot_id,timeslot_time) VALUES(:timeslot_id,:timeslot_time)");
                $stmt2->execute(array(':timeslot_id' => $timeslot_id, ':timeslot_time' => $time));
            }
            
        echo json_encode(['response'=>'Timeslot updated successfully','code' => 200]); 
	    
    }else{
        echo json_encode(['response'=>'Invalid Request','code' => 401]);
    }

?>