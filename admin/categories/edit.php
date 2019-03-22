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

if ($_GET['category_id']) {
    $category_id = $_GET['category_id'];
} else {
    $category_id = -1;
}
$category = getCategoryById($category_id);
$songs = getSongsByCategoryId($category_id);
?>

<body class="dashboard">
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Music On-Hold Now</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="logout.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Songs
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
                    <input id="add-new-song-btn" class="btn btn-primary pull-right" type="button" value="Add New Song">
                </div>
                <div class="row">
                    <div class="col-sm-12">
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
                                        <a class="song-remove-btn" attr-id="<?= $id ?>"><i class="fa fa-trash"></i></a>
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
</body>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/footer.php");
?>
<script>
    $(document).ready(function() {
        $('.use-dataTable').dataTable();
    });
</script> 