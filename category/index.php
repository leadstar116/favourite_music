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
    $category = getCategoryById($category_id);
?>

<body>
    <!-- title -->
    <div class="title text-center">
        <h3>Songs</h3>
    </div>    
    <!-- title end -->
    <!-- main Songs section     -->
    <div class="container">
        <div class="row shadow-box">
            <div class="col-md-6 songs-section">
                <div class="category-name">
                    <span><?= $category['category_name'] ?></span>
                </div>
                <div>
                    <ul id="songs_list">
                        <?php 
                        foreach($songs as $id => $song) {                             
                        ?>
                            <li attr-id="<?= $id ?>"><?= substr($song['song_name'], 0, -4) ?></li>
                        <?php
                        }    
                        ?>
                    </ul>                    
                </div>
                <div class="add-favorite">
                    <a id="add-favorite-btn">Add To Favorite</a>
                </div>
            </div>
            <div class="col-md-6 favorite-section">
                <div class="favorite-name">
                    <span>My Favorites</span>
                </div>
                <div>
                    <ul id="favorite_songs_list">
                        
                    </ul>                    
                </div>
                <div class="remove-favorite">
                    <a id="remove-favorite-btn">Remove From Favorite</a>
                </div>                
            </div>        
        </div>
        <div class="row">
            <div class="col-md-12 submit-mail">
                <input id="submit-mail-btn" class="btn btn-primary" type="submit" value="Submit">
            </div>
        </div>
    </div>
    <!-- main category section end -->
    <!-- remove favorite song confirmation modal -->
    <div id="removeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please confirm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to remove these songs from favorites?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modal-btn-yes" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- remove favorite song confirmation modal end            -->
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
                        <input type="text" class="form-control white-text" id="submit_name" placeholder="Name">
                        <input type="text" class="form-control white-text" id="submit_company" placeholder="Company">
                        <input type="email" class="form-control validate white-text" id="submit_email" placeholder="Email">
                        <input type="phone" class="form-control validate white-text" id="submit_phone" placeholder="Phone">
                        <textarea type="text" id="submit_message" class="md-textarea form-control" rows="4" placeholder="Notes, ideas, questions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <!-- <button type="button" class="btn btn-default" id="modal-btn-submit" data-dismiss="modal">Submit</button>                     -->
                    <input class="btn btn-primary" type="submit" value="Submit" data-dismiss="modal" id="modal-btn-submit">
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    include_once("../includes/footer.php");
?>