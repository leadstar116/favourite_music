<?php
if(file_exists("../config/database.php")) {
    include_once("../config/database.php");
    include_once("../core/category.php");
    include_once("../core/songs.php");
    include_once("../core/users.php");
} else {
    include_once($_SERVER['DOCUMENT_ROOT']. $subdir ."/config/database.php");
    include_once($_SERVER['DOCUMENT_ROOT']. $subdir ."/core/category.php");
    include_once($_SERVER['DOCUMENT_ROOT']. $subdir ."/core/songs.php");
    include_once($_SERVER['DOCUMENT_ROOT']. $subdir ."/core/users.php");
}

$database = new Database();
$db = $database->getConnection();

// prepare category object
$category_db = new Category($db);
$songs_db = new Songs($db);
$users_db = new Users($db);

function getAllCategories() {
    global $category_db;
    return $category_db->getAll();
}

function getCategoryById($category_id) {
    global $category_db;
    return $category_db->getById($category_id);
}

function removeCategory($category_id) {
    global $category_db;
    global $songs_db;
    $category_db->removeCategory($category_id);
    return $songs_db->deleteSongsByCategoryId($category_id);
}

function checkCategoryExist($category_name) {
    global $category_db;
    return $category_db->checkCategoryExist($category_name);
}

function addCategory($category_name) {
    global $category_db;
    return $category_db->addCategory($category_name);
}

function changeCategoryName($category_id, $category_name){
    global $category_db;
    global $subdir;
    $category = $category_db->getById($category_id);
    if($category_db->changeCategoryName($category_id, $category_name)) {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/audio_bin/'; 
        if(file_exists($dir.$category['category_name'])) {
            rename($dir.$category['category_name'], $dir.$category_name);
        }
        $dir = $_SERVER['DOCUMENT_ROOT'].$subdir.'/img/music-samples/'; 
        if(file_exists($dir.$category['category_name'].'.png')) {
            rename($dir.$category['category_name'].'.png', $dir.$category_name.'.png');
        }
    }
}

function getFavoriteSongsWithCategoryName($songs_id_array){
    global $db;
    $favorite = [];
    $qry = $db->prepare("select s.song_name, c.category_name FROM songs s LEFT JOIN categories c ON s.category_id = c.id WHERE s.id IN (". $songs_id_array .");");
    if ($qry === false) {
        trigger_error(mysqli_error($db->conn));
    } else {
        if ($qry->execute()) {
            $qry->store_result();
            $qry->bind_result($song_name, $category_name);
            while($qry->fetch()) {
                $favorite[] = $song_name.' - '.$category_name;
            }
        } else {
            trigger_error(mysqli_error($db->conn));
        }
    }
    $qry->close();
    return implode(', ', $favorite);
    
}
function getSongsByCategoryId($category_id) {
    global $songs_db;
    return $songs_db->getSongsByCategoryId($category_id);
}

function addNewSongToCategory($category_id, $song_name) {
    global $songs_db;
    return $songs_db->addNewSong($category_id, $song_name);
}

function checkSongExistInCategory($category_id, $song_name) {
    global $songs_db;
    return $songs_db->checkSongExist($category_id, $song_name);
}

function deleteSongById($song_id) {
    global $songs_db;
    return $songs_db->deleteSongById($song_id);
}

function addDownloadedCountOfSong($song_id, $count = 1) {
    global $songs_db;
    return $songs_db->addDownloadedCountOfSong($song_id, $count);
}

function checkLogin($username, $password) {
    global $users_db;
    return $users_db->checkLogin($username, $password);
}

function userRegister($username, $email, $password) {
    global $users_db;
    return $users_db->userRegister($username, $email, $password);
}

// get songs for categories in audio_bin
function loopDirectoriesAndGetSongs(){
    global $songs_db;
    $root_directory = scandir('../audio_bin');
    foreach($root_directory as $key=>$directory_name){
        if($key == 0 || $key == 1) {
            continue;
        }
        $songs = scandir('../audio_bin/' . $directory_name);
        foreach($songs as $sub_key => $song_name) {
            if($sub_key < 2 || $song_name == '.listing') {
                continue;
            }
            echo 'cate_id: '.($key-1).' name:'.$song_name.'<br/>';
            $songs_db->addNewSong(($key-1), $song_name);
        }
    }
}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }

    $files = scandir($dirPath);
    foreach($files as $key =>$song_name) {
        if($key == 0 || $key == 1) {
            continue;
        }
        unlink($dirPath. '/' .$song_name);
    }
    rmdir($dirPath);
}

?>