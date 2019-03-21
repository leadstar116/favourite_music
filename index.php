<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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
            
        </div>
    </div>
    <!-- main category section end -->
</body>

<?php
    include_once("includes/footer.php");
?>