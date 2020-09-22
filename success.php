<?php
  if(!empty($_GET['tid'] && !empty($_GET['email']))) {
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $tid = $GET['tid'];
    $email = $GET['email'];
  } else {
    header('Location: ./index.php');
  }
    session_start();
    session_unset(); 
    session_destroy(); 
    
  if(isset($_POST['submitDelivery'])){
      $uname = trim($_POST['email']);
      $upass = trim($_POST['pwrd']); 
        try
        {
              if($user->register($uname,$upass)) 
              {
                  $user->redirect('sign-up.php?joined');
              }
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();
        }
      
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" 
      content="default-src 'self' *.google.com/ data: gap: 'unsafe-eval' ws: ; 
      style-src https: 'self' 'unsafe-inline'; 
      script-src https: 'self' 'unsafe-inline';
      media-src 'none'; 
      font-src *;
      connect-src *;
      frame-src *;
      img-src 'self' data: content:;">
      <!--
      Also
      base-uri /abc/; - limit to content in this folder  v2
      form-action ; - limit where forms can be sent  v2
      
      VALUES
      'self' - anything from the same origin
      data: - data-uri (base64 images)
      gap: - phonegap and cordova used by plugins on iOS
      ws: - web sockets
      * - anything except data: and blobs
      filesystem: - access things on the local filesystem
      blob: - allow Binary Large OBjects
      mediastream: - allow streamed media
      content: - used by Cordova
      'none' - prevent anything in the category
      https: - anything over https://
      *.example.com - anything from any subdomain of example.com
      'unsafe-inline' - inline source elements like style attribute, onclick, or script tags 
      'unsafe-eval' - allow javascript eval( ). 
      -->
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel='stylesheet' href="View/Public/CSS/products-page.css">
  <link rel='stylesheet' href="View/Public/CSS/mobile.css">
  
  <title>Thank You</title>
</head>

<body>
<div class='page-grid'>
<!-- Navbar -->
  <nav class="navbar">
      <div class="nav-container-grid">
          <a class="navbar-brand" href='/index.php'>LOGO</a>
      </div>
  </nav>
  <style>
    .navbar {
        background-color: #007BFF;
    }
    .navbar-brand {
      color: #fff !important;
    }
  </style>
<!-- /Navbar -->

  <div class="container mt-4">
    <h2>Thank You For Your Purchase</h2>
    <hr>
    <p>Your transaction ID is <?php echo $tid; ?></p>
    <p>Check your <i><?php echo $email; ?></i> inbox for more information on your order</p>
    <p><a href="./index.php" class="btn btn-primary mt-2">Go Back</a></p>
  </div>

<!-- Footer -->
  <nav class="footer" style='text-align: center; position: absolute; bottom: 0; max-width: 1300px;'>
    <a class="footer-link" href="https://fortisureit.com/">FortisureIT</a>
    <a class="footer-link" href="https://food.fortisureit.com/">Food Partners</a>
  </nav>
<!-- /Footer -->
</div>
</body>
</html>