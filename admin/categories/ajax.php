<?php
$debugging = true;
if ($debugging) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$subdir = "/music-on-hold/music-tracks";
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
} else if($_POST['type'] == 'upload_temp_image') {
    if($_FILES["file"]["error"] == UPLOAD_ERR_OK && $_FILES["file"]['name'] != '')
    {          
        $error = false;
        $files = array();
        
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/upload/temp/';
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/upload')) {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/upload', 0777, true);
        }
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        foreach($_FILES as $file)
        {
            if(move_uploaded_file($file['tmp_name'], $uploaddir . basename('temp.png')))
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
        } else {
            $data = array('success' => 'Temp image was successfully uploaded');  
        }
    }
} else if($_POST['type'] == 'change_album_image') {
    if($_FILES["file"]["error"] == UPLOAD_ERR_OK && $_FILES["file"]['name'] != '')
    {          
        $error = false;
        $files = array();
        $category_name = $_POST['category_name'];
        
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/upload/temp/';
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/upload')) {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/upload', 0777, true);
        }
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        foreach($_FILES as $file)
        {
            if(move_uploaded_file($file['tmp_name'], $uploaddir . basename('temp.png')))
            {
                $uploaddir = $_SERVER['DOCUMENT_ROOT'].$subdir.'/img/music-samples/';
                if (!file_exists($_SERVER['DOCUMENT_ROOT'].$subdir.'/img')) {
                    mkdir($_SERVER['DOCUMENT_ROOT'].$subdir.'/img', 0777, true);
                }
                if (!file_exists($uploaddir)) {
                    mkdir($uploaddir, 0777, true);
                }
                rename($_SERVER['DOCUMENT_ROOT'] . '/upload/temp/temp.png', $uploaddir . basename($category_name.'.png'));
            }
            else
            {
                $error = true;
            }
        }
        if($error) {
            $data = array('error' => 'There was an error uploading your files');    
        } else {
            $data = array('success' => 'Image was successfully changed');  
        }
    }
}  else if($_POST['type'] == 'change_background_image') {
    if($_FILES["file"]["error"] == UPLOAD_ERR_OK && $_FILES["file"]['name'] != '')
    {          
        $error = false;
        $files = array();
        $category_name = $_POST['category_name'];
        
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/upload/temp/';
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/upload')) {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/upload', 0777, true);
        }
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        foreach($_FILES as $file)
        {
            if(move_uploaded_file($file['tmp_name'], $uploaddir . basename('temp.png')))
            {
                $uploaddir = $_SERVER['DOCUMENT_ROOT'].$subdir.'/img/music-samples/';
                if (!file_exists($_SERVER['DOCUMENT_ROOT'].$subdir.'/img')) {
                    mkdir($_SERVER['DOCUMENT_ROOT'].$subdir.'/img', 0777, true);
                }
                if (!file_exists($uploaddir)) {
                    mkdir($uploaddir, 0777, true);
                }
                rename($_SERVER['DOCUMENT_ROOT'] . '/upload/temp/temp.png', $uploaddir . basename($category_name.'_back.png'));
            }
            else
            {
                $error = true;
            }
        }
        if($error) {
            $data = array('error' => 'There was an error uploading your files');    
        } else {
            $data = array('success' => 'Image was successfully changed');  
        }
    }
} else if($_POST['type'] == 'add_category') {
    $category_name = $_POST['category_name'];
    $category_image_flag = $_POST['category_image_flag'];
    $check_result = checkCategoryExist($category_name);
    if ($check_result['success']) {
        // process file
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/audio_bin/' . $category_name;
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/audio_bin')) {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/audio_bin', 0777, true);
        }
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }
        if($category_image_flag) {
            $uploaddir = $_SERVER['DOCUMENT_ROOT'].$subdir.'/img/music-samples/';
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$subdir.'/img')) {
                mkdir($_SERVER['DOCUMENT_ROOT'].$subdir.'/img', 0777, true);
            }
            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/temp/temp.png')) {
                rename($_SERVER['DOCUMENT_ROOT'] . '/upload/temp/temp.png', $uploaddir . basename($category_name.'.png'));
            }    
            $data= array('success' => $uploaddir);        
        }        
    } else {
        $data = array('error' => $check_result['error']);    
    }
} else if($_POST['type'] == 'remove_category') {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/audio_bin/' . $category_name;
    deleteDir($uploaddir);
    removeCategory($category_id);
    $data = array('success' => '');  
}

echo json_encode($data);