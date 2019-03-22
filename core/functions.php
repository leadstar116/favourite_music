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
?>