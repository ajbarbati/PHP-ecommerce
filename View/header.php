
<?php
session_start();
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" 
        content="default-src 'self' *.stripe.com *.herokuapp.com data: gap: 'unsafe-eval' ws: ; 
        style-src https: 'self' 'unsafe-inline'; 
        script-src https: 'self' 'unsafe-inline' q.stripe.com;
        media-src 'none'; 
        font-src *;
        connect-src *;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a2caf9c750.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href="View/Public/CSS/products-page.css">
    <link rel='stylesheet' href="View/Public/CSS/mobile.css">

    <title>ORDERFORSURE</title>
</head>

<body>
    <div class='page-grid'>

  