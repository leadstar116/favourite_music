<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Music On Hold | Phone On Hold Music Tracks</title>
    <meta name="description" content="Quick and easy music on hold to fit your business. Listen to the best from over 100,000 hollywood quality tracks.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
 <!---removed the php to the links includes due to conflicts-->
 
 <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0084/2287.js" async="async"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" rel="stylesheet"> 

<link href="/style.css" rel="stylesheet" type="text/css" media="screen"> 
 
 
 
 
    
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
<span class="color-red">
    <!--color theme controlled by body tag-->

        <!--the main div-->
        <?php include '../../includes/topnav.php'; ?>
            <!--TOP NAVIGATION-->
            <?php include '../../includes/main-header-music-on-hold.php'; ?>
                <!--LOGO Social MAIN NAVIGATION-->
                </header>
</span>
				<section class="banner-musictracks"> <section class="content-musictracks">  <h2>Find your style.</h2><h5 class="tight">The right music for your messages on hold.</h5> </section> </section>
    <!-- title -->
    <div class="header text-center">
        <a id="submit-mail-btn">REVIEW & SUBMIT YOUR FAVORITES</a>
    </div>    
    <!-- title end -->
    <!-- main category section     -->
    <div class="container">
        <div class="row mb-3">
            <div class="dropdown dropdown-dark col-12">
                <div class="pull-right">
                    <span>Sort by: </span>
                    <select name="two" class="dropdown-select category-sort-option">                    
                        <option value="popularity">Most popular</option>
                        <option value="name">A-Z</option>                        
                    </select>
                </div>
            </div>
        </div>        
        <div class="row category-section">            
        <?php 
            foreach($categories as $id => $category) {
            ?>
                <div class="col-6 col-md-4 col-lg-2 category-div" id="category-<?= $id ?>" data-name="<?= $category['category_name'] ?>" data-popularity="<?= $category['category_popularity'] ?>">
                    <div class="category-wrapper">
                        <div class="category-album">
                            <a class="category-item" attr-id="<?= $id ?>">
                                <img src="<?= $subdir ?>/img/music-samples/<?= $category['category_name'] ?>.png" alt="" onerror="this.onerror=null;this.src='<?= $subdir ?>/img/music-samples/default_album.jpg';">
                            </a>
                        </div>
                        <div class="category-info">
                            <!-- <a class="category-item" attr-id="<?= $id ?>"><?= $category['category_name'] ?></a> -->
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
    <div class="row">
        <div id="songsModal" class="modal fade col-md-6" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="overlay-light">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body songsBody">
                            
                        </div>    
                    </div>                          
                </div>
            </div>
        </div>
        <!-- songs modal end -->
        <!-- Submit Modal -->
        <div id="submitModal" class="modal fade col-md-6" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title" style="width: 100%;">Submit your favorites</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <ul id="favorite_songs_list" class="favorite-playlist">
                                            
                            </ul>      
                            <div class="remove-favorite">
                                <a id="remove-favorite-btn">- REMOVE FROM FAVORITES</a>
                            </div>               
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
    </div>
</body>

<?php
    include_once("includes/footer.php");
?>