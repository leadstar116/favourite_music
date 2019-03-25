<?php
$debugging = true;
if ($debugging) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$subdir = "/favourite_music";
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/core/functions.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/header.php");

?>

<body class="dashboard">
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Music On-Hold Now</a>
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
                <form>       
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon">Name</span>
                        </div>
                        <input type="text" class="form-control" id="new-category-name" aria-describedby="basic-addon" required="true">
                    </div>                                                                
                    
                    <div class="col-sm-12 mb-3">                    
                        <input type="file" id="albumUploadBtn" class="btn btn-primary btn-add-image" style="display: none;">                    
                        <label for="albumUploadBtn" class="btn btn-primary mr-3">Add album</label>                       
                        <img id="imageSrc" style="width: 200px; height: 200px;" />                    
                    </div>                
                    <div class="col-sm-12">
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
