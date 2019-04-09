<?php 
    $debugging = true;
    if($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $subdir = "/music-on-hold/music-tracks";
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
        <div class="row">
            <div class="col-md-12">
                <div class="player mb-4">
                    <div class="pl"></div>
                    <div class="title"></div>                    
                    <div class="artist"></div>
                    <div class="cover"></div>
                    <div class="controls">
                        <div class="play"></div>
                        <div class="pause"></div>
                        <div class="rew"></div>
                        <div class="fwd"></div>
                    </div>
                    <div class="volume"></div>
                    <div class="tracker"></div>
                </div>
            </div>
        </div>
        <div class="row shadow-box">
            <?php 
                $album = $subdir.'/img/music-samples/'. $category['category_name'] .'.png';                 
            ?>
            <div class="col-md-6 songs-section" <?php if(file_exists($_SERVER['DOCUMENT_ROOT'].$album)) { ?> style="background-image: url('<?= $album ?>');" <?php } ?>>
                <div class="overlay">
                    <div class="category-name">
                        <span><?= $category['category_name'] ?></span>
                    </div>
                    <div>
                        <ul id="songs_list" class="playlist">
                            <?php 
                            $dir = '/audio_bin/' . $category['category_name'] .'/';                        
                            foreach($songs as $id => $song) {                             
                            ?>
                                <li attr-id="<?= $id ?>" style="position: relative;" audiourl="<?= $dir.$song['song_name'] ?>" cover="<?= $album ?>" >
                                    <?= substr($song['song_name'], 0, -4) ?>
                                    <a class="single-add-favorite-btn" attr-id="<?= $id ?>" attr-text="<?= substr($song['song_name'], 0, -4) ?>" audiourl="<?= $dir.$song['song_name'] ?>"><i class="fa fa-plus" title="Add to favorite"></i></a>
                                </li>
                            <?php
                            }    
                            ?>
                        </ul>                    
                    </div>
                    <div class="add-favorite">
                        <a id="add-favorite-btn">+ ADD TO FAVORITES</a>
                    </div>
                </div>                
            </div>
            <div class="col-md-6 favorite-section">
                <div class="favorite-name">
                    <span>My Favorites</span>
                </div>
                <div>
                    <ul id="favorite_songs_list" class="favorite-playlist">
                        
                    </ul>                    
                </div>
                <div class="remove-favorite">
                    <a id="remove-favorite-btn">- REMOVE FROM FAVORITES</a>
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
</body>

<?php
    include_once("../includes/footer.php");
?>