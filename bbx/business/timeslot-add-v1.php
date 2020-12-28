<?php

    require('../config/db.php');
    
    
    if(isset($_POST['partner_id'],$_POST['timeslot_group'],$_POST['timeslot_time'])){
        
        $partner_id = $_POST['partner_id'];
        $timeslot_group = $_POST['timeslot_group'];
        
      
       
        $stmt1 = $conn->prepare("INSERT INTO timeslots(partner_id,time_group) VALUES(:partner_id,:time_group)");
        $stmt1->execute(array(':partner_id' => $partner_id,':time_group' => $timeslot_group));
        
        if($stmt1->rowCount() == 1){
            
            echo json_encode(['response'=>'Timeslot added successfully','code' => 200]); 
            
        }else{
           echo json_encode(['response'=>'Error','code' => 401]);
        }
	    
    }else{
        echo json_encode(['response'=>'Invalid Request','code' => 401]);
    }

?>