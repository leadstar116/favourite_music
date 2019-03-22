<?php 
    $debugging = true;
    if($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $subdir = "/favorite-test";
    include_once("core/functions.php");
    include_once("includes/header.php");

    $categories = getAllCategories();            
?>

<body>
    <!-- title -->
    <div class="title text-center">
        <h3>Categories</h3>
    </div>    
    <!-- title end -->
    <!-- main category section     -->
    <div class="container">
        <div class="row">
        <?php 
            foreach($categories as $id => $category) {
            ?>
                <div class="col-6 col-md-4 col-lg-3" id="category-<?= $id ?>">
                    <div class="category-wrapper">
                        <div class="category-album">
                            <a href="category/index.php?id=<?= $id ?>"><img src="/img/music-samples/<?= $category['category_name'] ?>.png" alt="" onerror="this.onerror=null;this.src='/img/music-samples/default_album.jpg';"></a>
                        </div>
                        <div class="category-info">
                            <a href="category/index.php?id=<?= $id ?>"><?= $category['category_name'] ?></a>
                            <div class="category-detailed-info row">
                                <span class="col-6"><?= $category['category_popularity'] ?> <i class="fa fa-heart" style="color: #f00;"></i></span>
                                <span class="col-6"><?= $category['songs_count'] ?> <i class="fa fa-music"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }    
        ?>
        </div>
    </div>
    <!-- main category section end -->
</body>

<?php
    include_once("includes/footer.php");
?>