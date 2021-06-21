<?php
        $email=implode(" ",$_POST);
        $conn=mysqli_connect("localhost:3307","root","","demo_db");
        $sqlq="select consent from users where email='$email';";
        $s = mysqli_query($conn,$sqlq);
        $r =$s->fetch_array()[0];
        while($r==1)
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://c.xkcd.com/random/comic/");
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($ch);
                $doc  = new \DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $doc->loadHTML($data);
                foreach ($doc->getElementsByTagName('meta') as $meta) {
                        $metaData[] = array(
                        'property' => $meta->getAttribute('property'),
                        'content'  => $meta->getAttribute('content'),
                        );
                        if (!empty($metaData)) {
                
                                foreach ($metaData as $meta_property) {
                
                                if ($meta_property['property'] == 'og:url') {
                
                                $arrayURL = $meta_property['content'];
                
                                $explodeURL = explode('/', $arrayURL);
                
                                if (isset($explodeURL[3])) {
                
                                        $jsonParam = $explodeURL[3];
                                        $jsonURL   = "https://xkcd.com/" . $jsonParam . "/info.0.json";
                
                                        $chJson = curl_init();
                                        curl_setopt($chJson, CURLOPT_URL, $jsonURL);
                                        curl_setopt($chJson, CURLOPT_FOLLOWLOCATION, true);
                                        curl_setopt($chJson, CURLOPT_MAXREDIRS, 3);
                                        curl_setopt($chJson, CURLOPT_RETURNTRANSFER, true);
                                        $dataJson = curl_exec($chJson);
                
                                        $dataDecodedArray = json_decode($dataJson, true);
                                        $image_attachment = $dataDecodedArray['img'];
                                        $subject = "Image Attachment";
                                        $from    = "admin@itservice.com";
                                        $headers = "From: $from\r\n";
                                        $headers .= "MIME-Version: 1.0\r\n"
                                        . "Content-Type: multipart/mixed; boundary=\"1a2a3a\"";
                
                                        $message = "If you can see this MIME than your client doesn't accept MIME types!\r\n"
                                        . "--1a2a3a\r\n";
                                        $unsubscribeURL="http://localhost:8080/rtCamps/unsub.php?email=".$email;
                                        $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
                                        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
                                        . "<img src=".$dataDecodedArray['img'].">\r\n"
                                        . "<p><a href='".$unsubscribeURL."'>unsubscribe</a></p>\r\n"
                                        . "--1a2a3a\r\n";
                
                                        $file = file_get_contents($image_attachment);
                
                                        $message .= "Content-Type: image/jpg; name=\"picture.jpg\"\r\n"
                                        . "Content-Transfer-Encoding: base64\r\n"
                                        . "Content-disposition: attachment; file=\"picture.jpg\"\r\n"
                                        . "\r\n"
                                        . chunk_split(base64_encode($file))
                                        . "--1a2a3a--";
                
                
                                        $success    = mail($email, $subject, $message, $headers);
                                        $sqlq="select consent from users where email='$email';";
                                        $s = mysqli_query($conn,$sqlq);
                                        $r =$s->fetch_array()[0];
                                        if($r==0)
                                        {
                                                echo "Unsubscribed";
                                                break;
                                        }
                                        sleep(300);
                                        }
                                }
                        }
                }
        }
}
echo "Unsubscribed";
?>