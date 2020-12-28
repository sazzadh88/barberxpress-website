<?php

    require('../config/db.php');
    
    
    if(isset($_POST['partner_id'],$_POST['timeslot_group'],$_POST['timeslot_time'])){
        
        $partner_id = $_POST['partner_id'];
        $timeslot_group = $_POST['timeslot_group'];
        $timeslot_time = json_decode($_POST['timeslot_time'], true);
	    
	    
        $stmt = $conn->prepare("DELETE FROM timeslots WHERE partner_id = :partner_id");
        $stmt->execute([':partner_id' => $partner_id]);
       
        $stmt1 = $conn->prepare("INSERT INTO timeslots(partner_id,time_group) VALUES(:partner_id,:time_group)");
        $stmt1->execute(array(':partner_id' => $partner_id,':time_group' => $timeslot_group));
        
        if($stmt1->rowCount() == 1){
           
           $timeslot_id = $conn->lastInsertId();
           
           foreach($timeslot_time as $time){
                $stmt2 = $conn->prepare("INSERT INTO timeslot_inners (timeslot_id,timeslot_time) VALUES(:timeslot_id,:timeslot_time)");
                $stmt2->execute(array(':timeslot_id' => $timeslot_id, ':timeslot_time' => $time));
            }
            
            echo json_encode(['response'=>'Timeslot added successfully','code' => 200]); 
            
        }else{
           echo json_encode(['response'=>'Error','code' => 401]);
        }
	    
	    
    }else{
        echo json_encode(['response'=>'Invalid Request','code' => 401]);
    }

?>