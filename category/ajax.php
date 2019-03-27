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
    $notes = $_POST["message"];
    $fav = $_POST["favorite_songs_name"];
    $favorite_songs_id = $_POST["favorite_songs_id"];
    
    $favorite_songs_ids = explode(',', $favorite_songs_id);
    
    foreach($favorite_songs_ids as $id) {
        addDownloadedCountOfSong($id);
    }

    //$to = $email . ",production@easyonhold.com";
    $to = "supremedev116@gmail.com, aromaticconnect@gmail.com";
    $subject = "Your Easy On Hold Jukebox Confirmation";
    $body = "Thank you, " . $name . ", for selecting your favorite music from our jukebox!" . "\n";
    $body .= "\r\n";
    $body .= "Your favorites: "  . $fav . "\n";
    $body .= "\r\n";
    $body .= "Notes: " . $notes . "\n";
    $body .= "\r\n";
    $body .= "Submitted by: " . $name ."\n";
    $body .= "\r\n";
    $body .= "Company: " . $company ."\n";
    $body .= "\r\n";
    $body .= "Email: " . $email ."\n";
    $body .= "\r\n";
    $body .= "Phone: " . $phone ."\n";
    $body .= "\r\n";
    $body .= "Have you requested a free custom demo production yet? Visit: http://easyonhold.com/services/free-hold-message-demo/" . "\r\n";
    $body .= "\r\n";
    $body .= "Music on hold, when customized for your business with a friendly, professional voice track, is highly effective in reducing hang ups, keeping callers informed and improving your bottom line through better customer service." . "\r\n";
    $body .= "\r\n";
    $body .= "We would also like you to know about some of the legal and licensing issues associated with playing music on your business telephone system. Read about it here: http://easyonhold.com/learn/on-hold-music-licensing/How-To-Avoid-Music-Licensing-Fines/" . "\r\n";
    $body .= "\r\n";
    $body .= "Please contact us with any questions you may have. Our number is: 1-888-798-4653 (HOLD). We're here weekdays from 8:30am to 5:00pm Eastern Time." . "\r\n";
    $body .= "\r\n";
    $body .= "Thanks!";
    $body.=' ' . "\n";
    $body.=' ' . "\n";
    $body.='Easy On Hold' . "\n";
    $body.='www.easyonhold.com' . "\n";
    $body.=' ' . "\n";
    $body.='1-888-798-HOLD (4653)' . "\n";
    $body.=' ' . "\n";


    $headers .= 'From: info@easyonhold.com' . "\r\n";
    $headers .= 'Bcc: production@easyonhold.com, jen.fisher@easyonhold.com, tim.brown@easyonhold.com,julie.cook@easyonhold.com' . "\r\n";

    mail($to, $subject, $body, $headers);

    $data = array('success' => 'Successfully Sent');
}
echo json_encode($data);
?>