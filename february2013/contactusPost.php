<?php
  	//Send an email when someone comes along
    $to = "jason.levinsohn@gmail.com, nparks55@gmail.com";
    $subject = "LEVS DELIGHT - Contact Us Submission";
    $message = $_POST['name'] . " with email address <b>" . $_POST['email'] . "</b> has a question: <br /><br /> " . $_POST['message'];    
    $header = 'From: jlev711@gmail.com' . "\r\n" .
        'Reply-To: jlev711@gmail.com' . "\r\n" .
        'Content-Type: text/html';
        

    if(mail($to, $subject, $message, $header)) {
        echo '{"success": true, "name": "' . $_POST['name'] . '"}';
    } else {
        echo '{"success": false, "name": "' . $_POST['name'] . '"}';
    }
  

?>
