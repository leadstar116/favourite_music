<?php 
    $debugging = true;
    if($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $subdir = "/music-on-hold/music-tracks";
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
                            <a class="category-item" attr-id="<?= $id ?>">
                                <img src="<?= $subdir ?>/img/music-samples/<?= $category['category_name'] ?>.png" alt="" onerror="this.onerror=null;this.src='<?= $subdir ?>/img/music-samples/default_album.jpg';">
                            </a>
                        </div>
                        <div class="category-info">
                            <a class="category-item" attr-id="<?= $id ?>"><?= $category['category_name'] ?></a>
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
    <!-- songs modal -->
    <div id="songsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Songs</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                </div>                              
            </div>
        </div>
    </div>
    <!-- songs modal end -->
    <!-- Submit Modal -->
    <div id="submitModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="width: 100%;">Submit your favorites</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        <ul id="favorite_songs_list_modal">
                            
                        </ul>                    
                    </div>
                    <div class="submit-controls" style="margin-top:10px">
                        <input type="text" class="form-control white-text" id="submit_name" placeholder="Name" required="true">
                        <input type="text" class="form-control white-text" id="submit_company" placeholder="Company" required="true">
                        <input type="email" class="form-control validate white-text" id="submit_email" placeholder="Email" required="true">
                        <input type="phone" class="form-control validate white-text" id="submit_phone" placeholder="Phone" required="true">
                        <textarea type="text" id="submit_message" class="md-textarea form-control" rows="4" placeholder="Notes, ideas, questions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <!-- <button type="button" class="btn btn-default" id="modal-btn-submit" data-dismiss="modal">Submit</button>                     -->
                    <input class="btn btn-primary" type="submit" value="Submit" id="modal-btn-submit">
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    include_once("includes/footer.php");
?>