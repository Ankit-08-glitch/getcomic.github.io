<?php
    $conn=mysqli_connect("localhost:3307","root","","demo_db");
    if ($conn->connect_error) 
    {
        echo json_encode('connection_failed_mysql');
    } 
    else 
    {
        $user_email = $_REQUEST['email'];
        $sql_otp_1 = "UPDATE users SET consent = 0 WHERE email = '$user_email'";
        if (mysqli_query($conn, $sql_otp_1)) 
        {
            echo 'You have successfully unsubscribed.';
        }
        else
        {
            echo 'Something went wrong.Please try again later.';
        }

    }   
    ?>