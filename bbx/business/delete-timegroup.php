<?php
require('../config/db.php');


if(isset($_POST['mode'],$_POST['id'])){
    
    
    $mode = $_POST['mode'];
    $id = $_POST['id'];
    
    if($mode == 'PARENT'){
        $stmt = $conn->prepare("DELETE FROM timeslots WHERE id = :id");
    }else{
        $stmt = $conn->prepare("DELETE FROM timeslot_inners WHERE id = :id");
    }
    
    $stmt->execute([':id' => $id]);
    echo json_encode(['code' => 200, 'response' => "Deleted!"]);
    
    
}