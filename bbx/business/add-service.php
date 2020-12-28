<?php

    require('../config/db.php');
    
    
    if(isset($_POST['partner_id'])){
        
        $partner_id = $_POST['partner_id'];
        $category = $_POST['category'];
        $sub_category = $_POST['sub_category'];
        $service_name = $_POST['service_name'];
        $service_time = $_POST['service_time'];
        $service_category = $_POST['service_category'];
        $service_price = $_POST['service_price'];
        $service_description = $_POST['service_description'];
        $service_gender = $_POST['service_gender'];
    
       $stmt = $conn->prepare("INSERT INTO services VALUES(:id,:partner_id,:category,:sub_category,:service_name,:service_category,:service_description,:service_time,:service_gender,:service_price)");
       $stmt->execute(array(':id' => NULL,':partner_id' => $partner_id, ':category' => $category,':sub_category' => $sub_category,':service_name' => $service_name,':service_category' => $service_category,':service_description' => $service_description,':service_time' => $service_time,':service_gender' => $service_gender,':service_price' => $service_price));
       if($stmt->rowCount() == 1){
           echo json_encode(['response'=>'Service added successfully','code' => 200]); 
       }else{
           echo json_encode(['response'=>'Error','code' => 401]);
       }
    }

?>