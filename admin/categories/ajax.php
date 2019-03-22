<?php
$debugging = true;
if ($debugging) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$subdir = "/favourite_music";
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/core/functions.php");
$data = array();
if($_POST['type'] == 'remove_song') {
    $song_id = $_POST['song_id'];
    $song_name = $_POST['song_name'];
    $category_name = $_POST['category_name'];
    $filename = $_SERVER['DOCUMENT_ROOT'] . '/audio_bin/' . $category_name. '/'.$song_name;
    unlink($filename);
    deleteSongById($song_id);
} else if($_POST['type'] == 'add_new_song') {
    if($_FILES["file"]["error"] == UPLOAD_ERR_OK && $_FILES["file"]['name'] != '')
    {  
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];
        $error = false;
        $files = array();
        
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/audio_bin/' . $category_name. '/';
        $filename = $_FILES["file"]['name'];
        $check_result = checkSongExistInCategory($category_id, $filename);
        if($check_result['success']) {
            foreach($_FILES as $file)
            {
                $filename = $file['name'];
                if(move_uploaded_file($file['tmp_name'], $uploaddir . basename($file['name'])))
                {
                    $files[] = $uploaddir .$file['name'];
                }
                else
                {
                    $error = true;
                }
            }
            if($error) {
                $data = array('error' => 'There was an error uploading your files');    
            }
            if(!$error) {
                //Handle database:        
                $result = addNewSongToCategory($category_id, $filename);
                if($result['success']) {
                    $data = array('success' => 'Song was successfully added');    
                } else {
                    $data = array('error' => $result['error']);    
                }
            }
        } else {
            $data = array('error' => $check_result['error']);    
        }    
    }
}

echo json_encode($data);