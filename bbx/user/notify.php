<?php
    // Replace with the real server API key from Google APIs
    $apiKey = "AAAAH3BNhmA:APA91bHWntkpd4Po_QLUNkFf3qOx5Bw15rLB4ysLvILxN1ourAgp4vXJBicroiW5Xcx5cNWyTlcSScu68QI__Kaay0ER4f3XGLrG_JZ_jZtnQRYVHCN3-c1qx9L0GHnCy6MhMLLfE9BS";

    // Replace with the real client registration IDs
    $registrationIDs = array( "emtaNKk7B28:APA91bEoOVIekT05nPN462sGiP8zR8FVrXgx9oA0MuPvMsirJVvd5KgUn7kaNL8CxIZsok9Mjfcd3ANRxOKxejYqaKB7kWBFaidvZmqEyqMpGONvda599581Z77QcRyMtKsFRMzcYtXE");

    // Message to be sent
    $message = "Your message e.g. the title of post";

    // Set POST variables
    $url = 'https://android.googleapis.com/gcm/send';

    $fields = array(
        'registration_ids' => $registrationIDs,
        'data' => array( "message" => $message,"title" => "Hello From BBX", 'image' => 'https://www.gtp-marketplace.com/Content/images/logo_2016.png' ),
    );
    $headers = array(
        'Authorization: key=' . $apiKey,
        'Content-Type: application/json'
    );

    // Open connection
    $ch = curl_init();

    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_POST, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields));

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));

    // Execute post
    $result = curl_exec($ch);

    // Close connection
    curl_close($ch);
    // print the result if you really need to print else neglate thi
    echo $result;
    //print_r($result);
    //var_dump($result);
?>