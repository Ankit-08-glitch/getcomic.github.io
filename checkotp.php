<?php
   $x=implode(" ",$_POST);
   $r=substr($x,0,1);
   $email=substr($x,1);
   $m="E-Mail verififed";
   if($r=="1")
   {
       $conn=mysqli_connect("localhost:3307","root","","demo_db");
       $q="select count(email) from users where email='$email';";
       $s=mysqli_query($conn,$q);
       $c =$s->fetch_array()[0];
       echo "E-mail Verified";
       if($c==0)
       {
            $sqlq="insert into users(email,consent) values('$email',1);";
            $res = mysqli_query($conn,$sqlq);
       }
       else
       {
           $sqlq="UPDATE users SET consent = 1 WHERE email = '$email' ;";
           $res=mysqli_query($conn,$sqlq);
       }
   }
   else
    echo "Incorrect OTP! Please try Again";
?>
