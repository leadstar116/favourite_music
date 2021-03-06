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

$categories = getAllCategories();
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
                            <a class="nav-link active" href="">
                                Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Categories</h1>
                    <a id="add-new-category-btn" class="btn btn-primary pull-right" href="add.php">Add New</a>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table use-dataTable category-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Popularity</th>
                                    <th scope="col">Count of songs</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($categories as $id => $category) {
                                  ?>
                                <tr id="category-<?= $id ?>">
                                    <td><?= $id ?></td>
                                    <td><?= $category['category_name'] ?></td>
                                    <td><?= $category['category_popularity'] ?></td>
                                    <td><?= $category['songs_count'] ?></td>
                                    <td><?= $category['created_date'] ?></td>
                                    <td>
                                        <a class="category-view-btn" href="edit.php?category_id=<?= $id ?>"><i class="fa fa-eye"></i></a>
                                        <a class="category-remove-btn" attr-id="<?= $id ?>" attr-name="<?= $category['category_name'] ?>"><i class="fa fa-trash"></i></a>
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
    <div id="removeCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please confirm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to remove a category and all songs in it?</p>
                </div>
                <input id="modal_category_id" style="display:none;" >
                <input id="modal_category_name" style="display:none;" >                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="remove-category-btn-yes" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- remove song confirmation modal end            -->
</body>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . $subdir . "/includes/footer.php");
?>
<script>
    $(document).ready(function() {
        $('.use-dataTable').dataTable({
            "pageLength": 100
        });
    });
</script> 