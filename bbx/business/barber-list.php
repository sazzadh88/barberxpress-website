<?php
require('../config/db.php');
require('../config/func.php');
if(isset($_POST['partner_id'])){
    
    function getReviewAndRating($barber_id){
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM barbers_review WHERE barber_id = :barber_id");
        $stmt->execute([':barber_id' => $barber_id]);
        $rev = [];
        while($r = $stmt->fetchObject()){
            $rev[] = $r;
        }
        
        return $rev;
    }
    
    
    $partner_id = $_POST['partner_id'];
    $stmt = $conn->prepare("SELECT *  FROM barbers WHERE partner_id = :partner_id");
    $stmt->execute([':partner_id' => $partner_id]);
    $data = [];
    
    while($row = $stmt->fetchObject()){
        $row->ratingAndReview = getReviewAndRating($row->barber_id);
        $data[] = $row;
    }

    if(empty($data)){
        echo json_encode(['code' => 401, 'response' => 'Nothing found']);
    }else{
        echo json_encode(['code' => 200, 'response' => $data]);
    }
    
    
}