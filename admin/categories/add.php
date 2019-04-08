<?php
    $debugging = true;
    if ($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $subdir = "/music-on-hold/music-tracks";
    include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/core/functions.php");

    $show_error = false;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $category_name = $_POST['new-category-name'];
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
            if($_POST['album']) {
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
            }         
            
            $result = addCategory($category_name);
        
            if($result['success']) {
                header('Location: /music-on-hold/music-tracks/admin/');
            } else {
                $show_error = true;
                if(!isset($result['error'])) {
                    $error_message = "Error";
                }else {
                    $error_message = $result['error'];
                }
            }     
            
        } else {
            $show_error = true;
            $error_message = $check_result['error'];  
        }        
    }
    include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/header.php");
?>

<body class="dashboard">
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img src="<?= $subdir.'/assets' ?>/admin_logo.png" alt="" style="height:50px;"></a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="../logout.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add New Category</h1>
                </div>          
                <?php if($show_error) {?>
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?= $error_message ?>
                    </div>
                <?php }?>
                <form action="" method="post">       
                    <div class="input-group form-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon">Name</span>
                        </div>
                        <input type="text" class="form-control" name="new-category-name" aria-describedby="basic-addon" required="true">
                    </div>                                                                
                    
                    <div class="col-sm-12 mb-3 form-group">                    
                        <input type="file" id="albumUploadBtn" name="album" class="btn btn-primary btn-add-image" style="display: none;">                    
                        <label for="albumUploadBtn" class="btn btn-primary mr-3">Add album</label>                       
                        <img id="imageSrc" style="width: 200px; height: 200px;" />  
                    </div>                
                    <div class="col-sm-12 form-group">
                        <input id="save-category-btn" class="btn btn-primary" type="submit" value="Save">
                    </div>
                </form>
            </main>
        </div>
    </div>    
</body>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/footer.php");
?>
