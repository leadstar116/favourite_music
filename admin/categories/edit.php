<?php
$debugging = true;
if ($debugging) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$subdir = "/music-on-hold/music-tracks";
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/core/functions.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/header.php");

if ($_GET['category_id']) {
    $category_id = $_GET['category_id'];
} else {
    $category_id = -1;
}

if (isset($_POST['category_name'])) {
    changeCategoryName($category_id, $_POST['category_name']);
}
$category = getCategoryById($category_id);
$songs = getSongsByCategoryId($category_id);
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
                    <h1 class="h2">Category - <?= $category['category_name'] ?>
                        <span><?= $category['category_popularity'] ?> <i class="fa fa-heart" style="color: #f00;"></i></span>
                        <span><?= $category['songs_count'] ?> <i class="fa fa-music"></i></span>
                    </h1>
                    <div>
                        <input id="category_id" style="display:none;" value="<?= $category_id ?>">
                        <input id="category_name" style="display:none;" value="<?= $category['category_name'] ?>">
                        <input type="file" id="uploadBtn" class="btn btn-primary btn-add-image" style="display: none;">
                        <input type="button" id="changeCategoryNameBtn" class="btn btn-primary pull-right ml-2" value="Change Category Name">
                        <label for="uploadBtn" class="btn btn-primary pull-right">Add New Song</label>   
                        <div class="progress pull-right">
                            <div id="progressBar" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            </div>
                        </div>                 
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-sm-12">
                        <div class="mb-3 pb-3 border-bottom row">
                            <div class="col-6">
                                <input type="file" id="albumChangeUploadBtn" name="album" class="btn btn-primary btn-add-image" style="display: none;">                    
                                <label for="albumChangeUploadBtn" class="btn btn-primary mr-3">Change Image</label>                                                   
                                <img id="imageChangeSrc" style="width: 200px; height: 200px;" src="<?= $subdir.'/img/music-samples/'.$category['category_name'].'.png'; ?>"/> 
                                <a style="font-style: italic; color: grey;">Image size should be 300*300px</a>
                            </div>
                            <div class="col-6">
                                <input type="file" id="backgroundChangeUploadBtn" name="album" class="btn btn-primary btn-add-image" style="display: none;">                    
                                <label for="backgroundChangeUploadBtn" class="btn btn-primary mr-3">Change Background Image</label>                                                   
                                <img id="backgroundImg" style="width: 200px; height: 200px;" src="<?= $subdir.'/img/music-samples/'.$category['category_name'].'_back.png'; ?>"/> 
                                <a style="font-style: italic; color: grey;">Image size should be 300*300px</a>
                            </div>
                        </div>
                        <table class="table use-dataTable category-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Downloaded</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($songs as $id => $song) {
                                    ?>
                                <tr id="song-<?= $id ?>">
                                    <td><?= $id ?></td>
                                    <td><?= $song['song_name'] ?></td>
                                    <td><?= $song['downloaded_count'] ?></td>
                                    <td><?= $song['created_date'] ?></td>
                                    <td>
                                        <a class="song-remove-btn" attr-id="<?= $id ?>" attr-name="<?= $song['song_name'] ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- remove song confirmation modal -->
    <div id="removeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please confirm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to remove a song?</p>
                </div>
                <input id="song_id" style="display:none;" >
                <input id="song_name" style="display:none;" >                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="remove-song-btn-yes" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- remove song confirmation modal end            -->
    <!-- change category name modal -->
    <div id="changeCategoryNameModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="edit.php?category_id=<?= $category_id ?>" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Category Name</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-group col-12" name="category_name" value="<?= $category['category_name'] ?>" class="form-control" required="true">
                    </div>              
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" id="change-name-btn-yes" value="OK" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- change category name modal end            -->
</body>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/footer.php");
?>
<script>
    $(document).ready(function() {
        $('.use-dataTable').dataTable();
    });
</script> 