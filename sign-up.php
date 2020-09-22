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

if(isset($_POST['btn-signup']))
{
   $uname = trim($_POST['txt_uname']);
   $uPass = trim($_POST['txt_uPass']); 
 
   if($uname=="") {
      $error[] = "provide username !"; 
   }
   else if($uPass=="") {
      $error[] = "provide password !";
   }
   else if(strlen($uPass) < 6){
      $error[] = "Password must be atleast 6 characters"; 
   }
   else
   {
      try
      {
            if($user->register($uname,$uPass)) 
            {
                $user->redirect('sign-up.php?joined');
            }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}
include_once './View/nav.php';
include './View/side-nav.php';
?>
<div class="signup-grid">
    <form method="POST">
        <h2>Sign up.</h2><hr />
            <?php
            if(isset($error))
            {
               foreach($error as $error)
               {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
                  <?php
               }
            }
            else if(isset($_GET['joined']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='sign-in.php'>login</a> here
                 </div>
                 <?php
            }
            ?>
        <div class="form-group">
            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="txt_uPass" placeholder="Enter Password" required />
        </div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
            <button type="submit" name="btn-login"class="btn btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN UP
            </button>
        </div>
        <br />
        <label>Don't have account yet? <a href="sign-in.php">Sign In!</a></label>
    </form>
</div>
<style>

    .signup-grid {
        display: grid;
        margin: 1rem;
        place-items: center;
    }
    
</style>
<?php
include 'View/side-nav.php';
include 'View/footer.php';
?>