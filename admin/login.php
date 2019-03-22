<?php
    if(!isset($_SESSION)) {
        session_start(); 
    }

    $debugging = true;
    if($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $subdir = "/favourite_music";
    include_once("../core/functions.php");

    $show_error = false;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = checkLogin($_POST['username'], $_POST['password']);
        
        if($result['success']) {
            $_SESSION['user_id'] = $result['id'];
            header('Location: /favourite_music/admin/');
        } else {
            $show_error = true;
            $error_message = 'Wrong username or password';
        }
    }
    include_once("../includes/header.php");
?>

<body>    
    <div class="container">
        <?php if($show_error) {?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?= $error_message ?>
        </div>
        <?php }?>
        <div class="d-flex justify-content-center h-100">            
            <div class="card">
                <div class="card-header text-center">
                    <h3>Sign In</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input name="username" type="text" class="form-control validate" placeholder="username">                            
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input name="password" type="password" class="form-control validate" placeholder="password">
                        </div>                        
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="register.php">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
