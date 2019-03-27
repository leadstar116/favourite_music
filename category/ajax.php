<?php
$debugging = true;
if($debugging) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$subdir = "/favourite_music";
include_once("../core/functions.php");

if(isset($_POST)) {
    $name = $_POST["name"];
    $company = $_POST["company"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];
    $favorite_songs_name = $_POST["favorite_songs_name"];
    $favorite_songs_id = $_POST["favorite_songs_id"];
    
    $favorite_songs_ids = explode(',', $favorite_songs_id);
    
    foreach($favorite_songs_ids as $id) {
        addDownloadedCountOfSong($id);
    }
    /*
    $to = "supremedev116@gmail.com";
    $subject = "New Email Address for Mailing List";
    $headers = "From: $email\n";

    $message = "A visitor to your site has sent the following email address to be added to your mailing list.\n

    Email Address: $email";

    $user = "$email";
    $usersubject = "Thank You";
    $userheaders = "From: you@youremailaddress.com\n";

    $usermessage = "Thank you for subscribing to our mailing list.";

    $result = mail($to,$subject,$message,$headers);
    */
    // compose message
    $message = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit.";
    $message .= " Nam iaculis pede ac quam. Etiam placerat suscipit nulla.";
    $message .= " Maecenas id mauris eget tortor facilisis egestas.";
    $message .= " Praesent ac augue sed enim aliquam auctor. Ut dignissim ultricies est.";
    $message .= " Pellentesque convallis tempor tortor. Nullam nec purus.";

    // make sure each line doesn't exceed 70 characters
    $message = wordwrap($message, 70);

    // send email
    $result = mail('supremedev116@gmail.com', 'Nonsensical Latin', $message);
    echo $result;
    $data = array('success' => 'Successfully Sent');
}
echo json_encode($data);
?>