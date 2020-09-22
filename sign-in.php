<?php
    require "./View/header.php";
    include './Controller/database.php';
    include_once "./Model/product.php";
    include_once "./Model/details.php";
    include_once "./Model/card.php";
    include_once "./Model/user.php";
    include_once "./Model/categories.php";
    include_once "./Model/subcategories.php";
    include_once 'Model/user.php';

    // get database connection
    $database = new Database();
    $db = $database->connect();

    // initialize objects
    $category = new Category($db);
    $subcategory = new SubCategory($db);
    $product = new Product($db);
    $details = new Details($db);
    $card = new Card();
    $user = new User($db);

    // read all products in the database
    $productGet = $product->proRead();
    $categoryGet = $category->catRead();
 
    if($user->is_loggedin()!="")
        {
            $user->redirect('account-page.php');
        }

    if(isset($_POST['btn-login']))
        {
            $uname = $_POST['txt_uname_email'];
            $uPass = $_POST['txt_password'];
            
            if($user->login($uname,$uPass))
                {
                    $user->redirect('account-page.php');
                }
            else
                {
                    $error = "Wrong Details!";
                } 
    }

    include_once './View/nav.php';
    include './View/side-nav.php';
?>
<div class="login-register-grid">
    <form method="POST">
        <h2>Sign in.</h2><hr />
        <?php if(isset($error)){ ?>
            <div class="alert alert-danger">
                <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
            </div>
            <?php } ?>
        <div class="form-group">
            <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" required />
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="txt_password" placeholder="Your Password" required />
        </div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
            <button type="submit" name="btn-login"class="btn btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN IN
            </button>
        </div>
        <br />
        <label>Don't have account yet? <a href="sign-up.php">Sign Up!</a></label>
    </form>
</div>
<style>

    .login-register-grid {
        display: grid;
        margin: 1rem;
        place-items: center;
    }
    
</style>
<?php 
include 'View/side-nav.php';
include 'View/footer.php';
?> 