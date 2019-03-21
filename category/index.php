<?php 
    $debugging = true;
    if($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    
    include_once("../core/functions.php");
    include_once("../includes/header.php");

    $category_id = -1;
    if($_GET) {
        $category_id = $_GET['id'];
    }
    $songs = getSongsByCategoryId($category_id);
?>

<body>
    <!-- title -->
    <div class="title text-center">
        <h3>Songs</h3>
    </div>    
    <!-- title end -->
    <!-- main Songs section     -->
    <div class="container">
        <div class="row">
        <?php 
            foreach($songs as $id => $song) {
                echo $song['song_name'] . '<br/>';
            ?>
                
            <?php
            }    
        ?>
        </div>
    </div>
    <!-- main category section end -->
</body>

<?php
    include_once("../includes/footer.php");
?>