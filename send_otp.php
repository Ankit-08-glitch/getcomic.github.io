<?php
    $x=implode(" ",$_POST);
    $otp=substr($x,0,4);
    $email=substr($x,4);
    $msg="Your OTP is:- ".$otp;
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'From: Noreply <noreply@example.com>' . "\r\n";
    mail($email,"OTP VERIFICATION",$msg,$headers);
    echo "yes";
?>