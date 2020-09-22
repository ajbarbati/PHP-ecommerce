<?php

// User Information POST
    if (isset($_POST['submitUserInfo'])) {
        // reCAPTCHA Variables
            $secretKey = "6LcQz6kZAAAAANyYJJpesFkw4rkbTbtVCpKasnVd";
            $responseKey = $_POST['g-recaptcha-response'];

            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";
            $response = file_get_contents($url);
            $response = json_decode($response);
        // /reCAPTCHA Variables
        
        if ($response->success){
            // Connections
                ?><head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="Content-Security-Policy" 
                        content="default-src 'self' *.stripe.com *.google.com/ data: gap: 'unsafe-eval' ws: ; 
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
                    

                    <title>ORDERFORSURE</title>
                </head><?php
                ini_set('display_errors', 1);
                session_start();
                
                // Includes
                    require './Vendor/autoload.php';
                    require './Controller/database.php';
                    require './Model/transaction.php';
                    require './Model/details.php';
                    require './Model/product.php';
                // /Includes

                // DB Connection
                    $database = new Database();
                    $db = $database->connect();
                    $product = new Product($db);
                    $productGet = $product->proRead();
                    $details = new Details($db);
                    $cart = $_SESSION['cart'];
                    $total = array();
                    $itemDesc = array();
                // /DB Connection     
            // /Connections       
            
            // Cart price & description
                foreach ($cart as $value) {
                    // Make variable for storing all item descriptions
                    array_push($itemDesc, $value[1]);
                    array_push($total, (int)$value[2]);
                }
            // /Cart price & description

            // Sanitize POST Array
            $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

            // Variables
               $_SESSION["firstName"] = trim(htmlentities($POST['firstName']));
               $_SESSION["lastName"] = trim(htmlentities($POST['lastName']));
               $_SESSION["email"] = trim(htmlentities($POST['email']));
               $_SESSION["phone"] = trim(htmlentities($POST['phone']));
               $_SESSION["addy1"] = trim(htmlentities($POST['addy1']));
               $_SESSION["addy2"] = trim(htmlentities($POST['addy2']));
               $_SESSION["zip1"] = trim(htmlentities($POST['zip1']));
               $_SESSION["city"] = trim(htmlentities($POST['city']));
               $_SESSION["state"] = trim(htmlentities($POST['state']));
               $_SESSION["country"] = trim(htmlentities($POST['country']));
               $_SESSION["pwrd"] = trim(htmlentities($POST['pwrd']));
               $_SESSION["taxRate"] = 7.25;
               $_SESSION["salesTax"] = round(($_SESSION["taxRate"] * array_sum($total)/100));
               $_SESSION["finalTotal"] = array_sum($total)+$_SESSION["salesTax"];
               $_SESSION["displayModal"] = true;
            // /Variables
        }
        header('Location: formDelivery.php');
    }
// /User Information POST


// Stripe Payment POST
    if (empty($_POST['submitPayment'])) {
        // Connections
            ?><head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="Content-Security-Policy" 
                    content="default-src 'self' *.stripe.com *.google.com/ data: gap: 'unsafe-eval' ws: ; 
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
                

                <title>ORDERFORSURE</title>
            </head><?php

            session_start();

            // Includes
                require './Vendor/autoload.php';
                require './Model/customer.php';
                require './Controller/database.php';
                require './Model/transaction.php';
                require './Model/details.php';
                require './Model/product.php';
            // /Includes

            // DB Connection
                $database = new Database();
                $db = $database->connect();
                $product = new Product($db);
                $productGet = $product->proRead();
                $details = new Details($db);
                $cart = $_SESSION['cart'];
            // /DB Connection     
        // /Connections   

        \Stripe\Stripe::setApiKey('sk_test_x8wApeab6u366BLomcpZ9HhR00ejyCAaHg');

        // Sanitize POST
        $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
        $token = trim(htmlentities($POST['stripeToken']));

        // Customer Information - Stripe & MySQL
            // Create Customer In Stripe
            $customer = \Stripe\Customer::create(array(
            "source" => $token,
            "name" => $_SESSION["firstName"] . " " . $_SESSION["lastName"],
            "email" => $_SESSION["email"],
            "phone" => $_SESSION["phone"],
            "address" => array(
                "city" => $_SESSION["city"],
                "line1" => $_SESSION["addy1"],
                "line2" => $_SESSION["addy2"],
                "country" => $_SESSION["country"],
                "state" => $_SESSION["state"],
            )
            ));

            // Charge Customer
            $charge = \Stripe\Charge::create(array(
            "amount" => (round($_SESSION["finalTotal"])*100),
            "currency" => "usd",
            "description" => "Charge.php",
            "customer" => $customer->id
            ));

            // Customer Data
            $customerData = [
            'id' => $charge->customer,
            "first_name" => $_SESSION["firstName"],
            "last_name" => $_SESSION["lastName"],
            'email' => $_SESSION["email"],
            "phone" => $_SESSION["phone"],
            'password' => $_SESSION["pwrd"],
            "address" => array(
                "city" => $_SESSION["city"],
                "line1" => $_SESSION["addy1"],
                "line2" => $_SESSION["addy2"],
                "zipcode" => $_SESSION["zip1"],
                "country" => $_SESSION["country"],
                "state" => $_SESSION["state"],  
            )
            ];
        // /Customer Information - Stripe & MySQL

        // Transaction Information - Stripe & MySQL
            // Transaction Data
            $transactionData = [
            'id' => $charge->id,
            'customer_id' => $charge->customer,
            'product' => $charge->description,
            'product' => $charge->description,
            'product' => $charge->description,
            'amount' => $charge->amount,
            'currency' => $charge->currency,
            'status' => $charge->status,
            ];
        // /Transaction Information - Stripe & MySQL

        // Send Database Info
            // Instantiate Customer & Transaction
            $customer = new Customer($db);
            $transaction = new Transaction($db);

            // Add Customer * Transaction To DB
            $customer->addCustomer($customerData);
            $customer->addAddress($customerData);
            $transaction->addTransactionHead($transactionData, $customerData);
            $transaction->addTransactionDetail($cart, $customerData);
        // /Send Database Info

        // Email
            // Display Cart Items
                function loadCart($C) {
                $cartDisplay = "";
                foreach ($C as $value) {
                    $cartDisplay .= "
                                    <table class='es-left' cellspacing='0' cellpadding='0' align='left'>
                                        <tbody>
                                            <tr>
                                                <td class='es-m-p0r es-m-p20b esd-container-frame' width='180' valign='top' align='center'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td align='center' class='esd-block-image' style='font-size: 0px;'>
                                                                    <a target='_blank'><img class='adapt-img' src='https://res.cloudinary.com/dxleu7n2q/image/upload/v1593086934/ORDERFORSURE-site/" . $value[0] . ".jpg' alt style='display: block;' width='50'></a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table cellspacing='0' cellpadding='0' align='right'>
                                        <tbody>
                                            <tr>
                                                <td class='esd-container-frame' width='360' align='left'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td align='left' class='esd-block-text es-p5t'>
                                                                    <table style='width: 100%;' class='cke_show_border' cellspacing='0' cellpadding='0' border='0'>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <p style='line-height: 100%;'><strong class='p_name'>" . $value[1] . "</strong></p>
                                                                                </td>
                                                                                <td style='text-align: center;' width='15%'>
                                                                                    <p class='p_quantity' style='line-height: 100%;'>1</p>
                                                                                </td>
                                                                                <td style='text-align: center;' width='30%'>
                                                                                    <p class='p_price' style='line-height: 100%;'>$" . $value[2] . "</p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align='left' class='esd-block-text'>
                                                                    <p style='color: #999999;' class='p_option'>Item Description</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    


                                    <table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0'>
                                        <tbody>
                                            <tr>
                                                <td style='border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;'></td>
                                            </tr>
                                        </tbody>
                                    </table>
                    ";
                }
                return $cartDisplay;
                }
            // /Display Cart Items

            // Email Information & Body
                $body = [
                    'Messages' => [
                        [
                        'From' => [
                            'Email' => "fortisureit@gmail.com",
                            'Name' => "FortisureIT"
                        ],
                        'To' => [
                            [
                            'Email' => $_SESSION["email"],
                            'Name' => $_SESSION["firstName"] . " " . $_SESSION["lastName"]
                            ]
                        ],
                        'Subject' => "FortisureIT Order Confirmation",
                        'HTMLPart' => "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                                    <html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office'>

                                    <head>
                                        <meta charset='UTF-8'>
                                        <meta content='width=device-width, initial-scale=1' name='viewport'>
                                        <meta name='x-apple-disable-message-reformatting'>
                                        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                                        <meta content='telephone=no' name='format-detection'>
                                        <title></title>
                                        <!--<![endif]-->
                                        <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
                                    </head>

                                    <body>
                                        <div class='es-wrapper-color'>
                                            <!--[if gte mso 9]>
                                            <v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'>
                                            <v:fill type='tile' color='#eeeeee'></v:fill>
                                            </v:background>
                                        <![endif]-->
                                            <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='esd-email-paddings' valign='top'>
                                                            <table class='es-content esd-header-popover' cellspacing='0' cellpadding='0' align='center'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class='esd-stripe' align='center'>
                                                                            <table class='es-content-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff' align='center'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p5t es-p5b es-p10r es-p10l' align='left' bgcolor='#333333' style='background-color: #333333;' esd-general-paddings-checked='false'>
                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame' width='580' valign='top' align='center'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-image' align='center' style='font-size: 0px;'><a target='_blank' href='https://viewstripo.email/'><img class='adapt-img' src='https://ircoii.stripocdn.email/content/guids/cab_pub_7cbbc409ec990f19c78c75bd1e06f215/images/Check_Mark_in_Circle_Orange.png' alt width='105' style='display: block; padding: 10px;'></a></td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p10t es-p15b es-p20r es-p20l' align='left' bgcolor='#ffcc99' style='background-color: #ffcc99;' esd-general-paddings-checked='false'>
                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame' width='560' valign='top' align='center'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text es-p5t es-p5b' align='center'>
                                                                                                                            <div class='esd-text'>
                                                                                                                                <h2><b style='color: #242424; font-size: 35px;'>Thank You For Your </b>
                                                                                                                                    <font color='#242424' style='font-size: 35px;'><b>Purchase</b></font><b style='color: #242424; font-size: 35px;'>!</b>
                                                                                                                                </h2>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text es-p10l' align='center'>
                                                                                                                            <p style='color: #242424; line-height: 150%;'>Greetings ".$_SESSION["firstName"]." ".$_SESSION["lastName"].", we've received your order and are working on putting it together now.</p>
                                                                                                                            <p style='color: #242424; line-height: 150%;'>We'll email you an update when we've shipped it.</p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class='es-content esd-footer-popover' cellspacing='0' cellpadding='0' align='center'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class='esd-stripe' align='center'>
                                                                            <table class='es-content-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff' align='center'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p35r es-p35l' align='left' bgcolor='#efefef' style='background-color: #efefef;'>
                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame' width='530' valign='top' align='center'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text es-p5t es-p5b es-p10r es-p10l' bgcolor='#eeeeee' align='left'>
                                                                                                                            <table style='width: 500px;' class='cke_show_border' cellspacing='1' cellpadding='1' border='0' align='left'>
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td width='80%'>
                                                                                                                                            <h4 style=text-align:center;>Transaction ID #</h4>
                                                                                                                                        </td>
                                                                                                                                        <td width='20%'>
                                                                                                                                            <h4 style=text-align:center;>".$charge->id."</h4>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p5t es-p20r es-p20l' align='left' esd-general-paddings-checked='false'>
                                                                                            <!--[if mso]><table width='560' cellpadding='0' cellspacing='0'><tr><td width='178' valign='top'><![endif]-->
                                                                                            <table class='es-left' cellspacing='0' cellpadding='0' align='left'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='es-m-p0r es-m-p20b esd-container-frame' width='178' valign='top' align='center'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align='center' class='esd-block-text'>
                                                                                                                            <p><strong>ITEM IMAGE</strong></p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if mso]></td><td width='20'></td><td width='362' valign='top'><![endif]-->
                                                                                            <table cellspacing='0' cellpadding='0' align='right'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame' width='362' align='left'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align='left' class='esd-block-text'>
                                                                                                                            <table style='width: 100%;' class='cke_show_border' cellspacing='1' cellpadding='1' border='0'>
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td style='font-size: 13px;'>
                                                                                                                                            <p><strong>NAME </strong></p>
                                                                                                                                        </td>
                                                                                                                                        <td style='text-align: center; font-size: 13px; line-height: 100%;' width='15%'>
                                                                                                                                            <p><strong>QTY </strong></p>
                                                                                                                                        </td>
                                                                                                                                        <td style='text-align: center; font-size: 13px; line-height: 100%;' width='30%'>
                                                                                                                                            <p><strong>PRICE</strong></p>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if mso]></td></tr></table><![endif]-->
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-block-spacer es-p10b es-p20r es-p20l' align='center' style='font-size: 0px;'>
                                                                                            <table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style='border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;'></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p5b es-p20r es-p20l' align='left' esd-general-paddings-checked='false' esdev-config='h169'>
                                                                ".loadCart($cart)."

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p20r es-p20l' align='left'>
                                                                                            <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td width='560' class='esd-container-frame' align='center' valign='top'>
                                                                                                            <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align='center' class='esd-block-spacer es-p20r es-p20l' style='font-size:0'>
                                                                                                                            <table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0'>
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td style='border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;'></td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p10t es-p20r es-p20l' align='left'>
                                                                                            <!--[if mso]><table width='560' cellpadding='0' cellspacing='0'><tr><td width='430' valign='top'><![endif]-->
                                                                                            <table cellpadding='0' cellspacing='0' class='es-left' align='left'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td width='430' class='esd-container-frame es-m-p20b' align='center'>
                                                                                                            <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text' align='right'>
                                                                                                                            <p style='line-height: 100%; font-size: 16px;'><span style='font-size:18px;'>Subtotal:<br>Shipping<br>Discount:<br>Tax:</span><br><strong><span style='font-size:20px;'>Order Total:</span></strong></p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if mso]></td><td width='20'></td><td width='110' valign='top'><![endif]-->
                                                                                            <table cellpadding='0' cellspacing='0' class='es-right' align='right'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td width='110' align='center' class='esd-container-frame'>
                                                                                                            <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text' align='left'>
                                                                                                                            <p style='line-height: 100%; font-size: 16px;'><span style='font-size:18px;'><span style='font-size:17px;'>$".number_format(($_SESSION["finalTotal"]-$_SESSION["salesTax"]), 2)."<br>$0.00<br>$0.00</span><br><span style='font-size:17px;'>$".number_format($_SESSION["salesTax"], 2)."</span></span><br><span style='font-size:19px;'><strong>$".number_format($_SESSION["finalTotal"], 2)."</strong></span></p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if mso]></td></tr></table><![endif]-->
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p20r es-p20l' align='left'>
                                                                                            <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td width='560' class='esd-container-frame' align='center' valign='top'>
                                                                                                            <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align='center' class='esd-block-spacer es-p5t es-p5b es-p20r es-p20l' style='font-size:0'>
                                                                                                                            <table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0'>
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td style='border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;'></td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p5t es-p5b es-p35r es-p35l' esd-custom-block-id='7796' align='left' bgcolor='#efefef' style='background-color: #efefef;'>
                                                                                            <!--[if mso]><table width='530' cellpadding='0' cellspacing='0'><tr><td width='255' valign='top'><![endif]-->
                                                                                            <table class='es-left' cellspacing='0' cellpadding='0' align='left'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame es-m-p20b' width='255' align='left'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text es-p5b' align='center'>
                                                                                                                            <h4 style='font-size: 18px;'><strong>Address Summary</strong></h4>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text' align='left'>
                                                                                                                            <p style='line-height: 100%; font-size: 16px;'>
                                                                                    ".$_SESSION["addy1"]."<br>
                                                                                    ".$_SESSION["city"]." ".$_SESSION["state"]." ".$_SESSION["zip1"]."<br>
                                                                                    Phone: ".$phone."<br>
                                                                                </p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if mso]></td><td width='20'></td><td width='255' valign='top'><![endif]-->
                                                                                            <table class='es-right' cellspacing='0' cellpadding='0' align='right'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame' width='255' align='left'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text es-p5b' align='center'>
                                                                                                                            <h4 style='font-size: 18px;'><strong>Invoice Details</strong></h4>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-text' align='left'>
                                                                                                                            <p style='line-height: 120%; font-size: 16px;'>January 1st, 2016</p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if mso]></td></tr></table><![endif]-->
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class='esd-structure es-p10t es-p10b es-p20r es-p20l' align='left' esd-general-paddings-checked='false' bgcolor='#333333' style='background-color: #333333;'>
                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class='esd-container-frame' width='560' valign='top' align='center'>
                                                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class='esd-block-social es-p5t es-p5b' align='center' style='font-size:0'>
                                                                                                                            <table class='es-table-not-adapt es-social' cellspacing='0' cellpadding='0'>
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                        <td><br></td>
                                                                                                                                        <td class='es-p15r' valign='top' align='center'><a href><img title='Twitter' src='https://stripo.email/cabinet/assets/editor/assets/img/social-icons/circle-gray/twitter-circle-gray.png' alt='Tw' width='32' height='32'></a></td>
                                                                                                                                        <td class='es-p15r' valign='top' align='center'><a href><img title='Facebook' src='https://stripo.email/cabinet/assets/editor/assets/img/social-icons/circle-gray/facebook-circle-gray.png' alt='Fb' width='32' height='32'></a></td>
                                                                                                                                        <td class='es-p15r' valign='top' align='center'><a href><img title='Youtube' src='https://stripo.email/cabinet/assets/editor/assets/img/social-icons/circle-gray/youtube-circle-gray.png' alt='Yt' width='32' height='32'></a></td>
                                                                                                                                        <td valign='top' align='center'><a href><img title='Linkedin' src='https://stripo.email/cabinet/assets/editor/assets/img/social-icons/circle-gray/linkedin-circle-gray.png' alt='In' width='32' height='32'></a></td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align='center' class='esd-block-text es-p5t es-p5b'>
                                                                                                                            <p style='line-height: 120%; color: #999999;'>The FortisureIT Team</p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align='center' class='esd-block-text es-p5t es-p5b'>
                                                                                                                            <p style='line-height: 120%; color: #999999;'>If you didn't create an account using this email address, please ignore this email or unsubscribe.</p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align='center' class='esd-block-text' esd-links-color='#3d85c6'>
                                                                                                                            <p><strong><a target='_blank' style='line-height: 150%; color: #3d85c6;' class='unsubscribe' href>Unsubscribe</a> • <a target='_blank' style='line-height: 150%; color: #3d85c6;' href='https://viewstripo.email'>Update Preferences</a> • <a target='_blank' style='line-height: 150%; color: #3d85c6;' href='https://viewstripo.email'>Customer Support</a></strong></p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </body>

                                    </html>"
                        ]
                    ]
                ];
            // /Email Information & Body

            // cURL
                $ch = curl_init();
                
                curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                    'Content-Type: application/json')
                );
                curl_setopt($ch, CURLOPT_USERPWD, "0fe2cec698e2d9954118f307dd9fd2a1:8a87ea156a5fe4a3c86e794ec529e517");
                $server_output = curl_exec($ch);
                curl_close ($ch);
            // /cURL
        // Email
        
        header('Location: success.php?tid='.$charge->id.'&email='.$_SESSION["email"]);
    }
// /Stripe Payment POST