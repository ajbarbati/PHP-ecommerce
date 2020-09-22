<!DOCTYPE html>
<html lang="en">

<head>
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

<?php 
// Connections 
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
    $total = array();
    $itemDesc = array();
  // /DB Connection    
// /Connections
?>

<!-- STRIPE MODAL -->
  <?php
    // Display Cart Items
        function loadCart($C) {
        $cartDisplay = "";
        foreach ($C as $value) {
            $cartDisplay .= "<table class='es-left' cellspacing='0' cellpadding='0' align='left'>
                                <tbody>
                                    <tr>
                                        <td class='es-m-p0r es-m-p20b esd-container-frame' width='180' valign='top' align='center'>
                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                <tbody>
                                                    <tr>
                                                        <td align='center' class='esd-block-image' style='font-size: 0px; margin-top:5px'>
                                                        <a target='_blank'><img class='adapt-img' src='View/Public/Images/product-images/".$value[0].".jpg' alt style='display: block; margin-top: 10px;' width='50'></a></td>
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
                                                            <p style='color: #999999; margin:0px;'>" . $value[7] . "</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            


                            <table border='0' width='100%' height='0px' cellpadding='0' cellspacing='0' style='text-align:center;'>
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

    // /Display Cart Totals
      function displayTotal(){
        $totalsHTML = "<table class='es-content esd-footer-popover' cellspacing='0' cellpadding='10' align='center'>
                        <tbody>
                            <tr>
                              <td class='esd-block-text' align='right'>
                                  <p style='line-height: 100%; font-size: 16px; margin:0;'><span style='font-size:18px; margin-left:200px;'>Subtotal:<br>Shipping<br>Discount:<br>Tax:</span><br><strong><span style='font-size:20px;'>Order Total:</span></strong></p>
                              </td>
                              <td class='esd-block-text' align='left' style='margin-left:50px;'>
                                  <p style='line-height: 100%; font-size: 16px; margin:0;'><span style='font-size:18px;'><span style='font-size:17px;'>$".number_format(($_SESSION["finalTotal"]-$_SESSION["salesTax"]), 2)."<br>$0.00<br>$0.00</span><br><span style='font-size:17px;'>$".number_format($_SESSION["salesTax"], 2)."</span></span><br><span style='font-size:19px;'><strong>$".number_format($_SESSION["finalTotal"], 2)."</strong></span></p>
                              </td>
                            </tr>
                        </tbody>
                      </table>
        ";
        return $totalsHTML;
      }
    // /Display Cart Totals
  ?>

  <!-- Onload display form modal -->
    <script type="text/javascript">
      var myVar = <?php echo $_SESSION['displayModal'];?>;
      if(myVar == true){
        $(window).on('load',function(){
          $('#formModal').modal('show');
        });
      };
    </script>
  <!-- Onload display form modal -->

  <!-- Stripe Payment Modal-->
    <div id="formModal" class="modal hide fade in" data-keyboard="false" data-backdrop="static" style="margin-bottom: 0.5rem;" >
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
            <div style="padding: 1rem 1rem; border-bottom: 1px solid #dee2e6; text-align:center;">
              <h3 class="modal-title">One Last Thing!</h3>
              <p style="padding: 0rem; text-align:center; font-size: 16px; margin: 0;">Please look over your cart to make sure your order is correct </p>
            </div>
          <!-- /Modal Header -->
      
          <!-- Modal Body -->
            <div class="modal-body" style="padding-top: 0px;">
              <form id="payment-form" action="charge.php" method="POST" class="card-body">
                <!-- Header For Cart -->
                  <table cellspacing="0" cellpadding="0" text-align="right" style="margin-left:40px;">
                      <tbody>
                          <tr>
                              <td class="esd-container-frame" width="362" text-align="left">
                                  <table width="100%" cellspacing="0" cellpadding="0">
                                      <tbody>
                                          <tr>
                                              <td text-align="left" class="esd-block-text">
                                                  <table style="width: 100%; margin-left: 5px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0">
                                                      <tbody>
                                                          <tr>
                                                              <td style="font-size: 13px;">
                                                                  <p><strong>NAME/DESCRIPTION</strong></p>
                                                              </td>
                                                              <td style="text-align: center; font-size: 13px; line-height: 100%;" width="15%">
                                                                  <p><strong>QTY</strong></p>
                                                              </td>
                                                              <td style="text-align: center; font-size: 13px; line-height: 100%;" width="30%">
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
                <!-- /Header For Cart -->

                <!-- Cart Item Container -->
                  <div class="border rounded" style="height:400px; overflow-y: scroll;">
                    <?php echo loadCart($cart)?>
                  </div>
                <!-- /Cart Item Container -->

                <!-- Cart Totals Container -->
                  <?php echo displayTotal()?>
                <!-- /Cart Totals Container -->

                <!-- Stripe Example Card -->
                  <hr style="margin-top:0">
                  <div class="form-row"> 
                    <label for="card-element">Credit/Debit & Zip<sup style="color:red;">*</sup></label>
                    <div id="card-element" class="form-control"></div>
                    <div id="card-errors" role="alert"></div>
                  </div>
                <!-- /Stripe Example Card -->

                <!-- Submit -->
                  <button class="btn btn-primary btn-block mt-4" id="submitPayment" name="submitPayment">Place Your Order!</button>
                <!-- /Submit -->
              </form>
            </div>
          <!-- /Modal Body -->
        </div>
      </div>
    </div>
  <!-- /Stripe Payment Modal -->

<!-- STRIPE MODAL -->

<main class="mt-2">
  <div class="container wow fadeIn">
  <div class="row">
    <div class="col-md-8 mb-4">
      <h2 class="my-4 text-center">Payment Delivery/Shipping</h2>
        <div class="card">
          <!-- Form -->
            <form id="payment-form" action="charge.php" method="POST" class="card-body needs-validation" novalidate>
              <!-- User Information -->
                <div class="row">
                  <!-- First Name -->
                    <div class="col-md-6 mb-2">
                      <div class="md-form ">
                        <label for="firstName">First name<sup style="color:red;">*</sup></label>
                        <input id="chkout-firstName" type="text" name="firstName" class="form-control StripeElement StripeElement--empty" placeholder="John" maxlength="50" required>
                      </div>
                    </div>
                  <!-- /First Name -->

                  <!-- Last Name -->
                    <div class="col-md-6 mb-2">
                      <div class="md-form">
                        <label for="lastName">Last name<sup style="color:red;">*</sup></label>
                        <input id="chkout-lastName" type="text" name="lastName" class="form-control StripeElement StripeElement--empty" placeholder="Smith" maxlength="50" required>
                      </div>
                    </div>
                  <!-- /Last Name -->
                </div>

                <div class="row">
                  <!-- Email -->
                    <div class="col-md-6 mb-2">
                        <label for="email">Email<sup style="color:red;">*</sup></label>
                        <input id="chkout-email" type="email" name="email" class="form-control StripeElement StripeElement--empty" placeholder="JohnSmith@email.com" maxlength="50" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                  <!--/Email -->

                  <!-- Phone -->
                    <div class="col-md-6 mb-2">
                      <div class="md-form">
                        <label for="phone">Phone<sup style="color:red;">*</sup></label>
                        <input id="chkout-phone" type="tel" name="phone" class="form-control StripeElement StripeElement--empty" placeholder="1-(555)-555-5555" maxlength="10" onkeypress="return isNumber(event)" required>
                        <div class="invalid-feedback">Please provide a valid phone.</div>
                      </div>
                    </div>
                  <!--/Phone -->
                </div>
                <hr>
              <!-- /User Information -->


              <!-- Delivery Options-->
                <div id="delivery" style="width:100%;">
                  <!-- Address 1 -->
                    <div class="md-form">
                      <!-- Address-->
                        <div class="mb-2">
                          <label for="chkout-address">Address<sup style="color:red;">*</sup></label>
                          <input id="chkout-address" type="text" name="addy1" class="form-control StripeElement StripeElement--empty" placeholder="1234 Main St" maxlength="150" required>
                          <div class="invalid-feedback">Please provide a valid address.</div>
                        </div>
                      <!-- /Address-->
                    </div>
                
                    <div class="row">
                      <!-- City -->
                        <div class="col-md-6 mb-2">
                          <label for="city"></label>City<sup style="color:red;">*</sup></label>
                          <input id="chkout-city" type="text" name="city" class="form-control StripeElement StripeElement--empty" maxlength="50" required>
                          <div class="invalid-feedback">Please provide a valid city.</div>
                        </div>
                      <!-- /City -->

                      <!-- State -->
                        <div class="col-md-6 mb-2">
                          <label for="chkout-state">State<sup style="color:red;">*</sup></label>
                          <select id="chkout-state" name="state" class="custom-select d-block w-100 StripeElement StripeElement--empty"  required>
                          <!-- State Options -->
                            <option value="">Select...</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                          <!-- /State Options -->
                          </select>
                          <div class="invalid-feedback">Please provide a valid state.</div>
                          
                        </div>
                      <!-- /State -->
                    </div>

                    <div class="row">
                      <!-- Zip -->
                        <div class="col-md-6 mb-2">
                          <label for="chkout-zip">Zipcode<sup style="color:red;">*</sup></label>
                          <input id="chkout-zip" type="text" name="zip1" class="form-control StripeElement StripeElement--empty" maxlength="10" onkeypress="return isNumber(event)" required>
                          <div class="invalid-feedback">Please provide a valid zip code.</div>
                        </div>
                      <!-- /Zip -->

                      <!-- Country -->
                        <div class="col-md-6 mb-2">
                          <label for="country">Country<sup style="color:red;">*</sup></label>
                          <select id="chkout-country" name="country" class="custom-select d-block w-100 StripeElement StripeElement--empty" required>
                            <!-- Country Options -->
                              <option value="">Select...</option>
                              <option value="US">United States</option>
                              <option value="AT">Austria</option>
                              <option value="BG">Bulgaria</option>
                              <option value="BR">Brazil</option>
                              <option value="CA">Canada</option>
                              <option value="CZ">Czech Republic</option>
                              <option value="DK">Denmark</option>
                              <option value="FR">French</option>
                              <option value="DE">Germany</option>
                              <option value="IN">India</option>
                              <option value="IT">Italy</option>
                              <option value="IE">Ireland</option>
                              <option value="MA">Morocco</option>
                              <option value="NL">Netherlands</option>
                              <option value="PL">Poland</option>
                              <option value="PT">Portugal</option>
                              <option value="RO">Romania</option>
                              <option value="RU">Russia</option>
                              <option value="SG">Singapore</option>
                              <option value="SK">Slovakia</option>
                              <option value="ES">Spain</option>
                              <option value="SE">Sweden</option>
                              <option value="CH">Switzerland</option>
                              <option value="GB">United Kingdom</option>
                            <!-- /Country Options -->
                          </select>
                          <div class="invalid-feedback">Please provide a valid country.</div>
                          
                        </div>
                      <!-- /Country -->
                    </div>
                    <br>
                  <!-- Address 1 -->
                  
                  <!-- Address 2 optional Make checkbox-->
                    <div class="mb-2">
                      <label for="chkout-address2">Address 2 (optional)</label>
                      <input id="chkout-address2" type="text" name="addy2" class="form-control StripeElement StripeElement--empty" placeholder="Apartment or suite" maxlength="150">
                    </div>
                  <!-- /Address 2 optional-->
                </div>
                <hr>
              <!-- /Delivery Options-->


              <!-- Account Creation -->

                <!-- Password -->
                  <div class="mb-2">
                    <label for="pwrd">Create An Account Password (optional)</label>
                    <input id="chkout-pwrd" type="password" name="pwrd" class="form-control StripeElement StripeElement--empty" minlength="8" maxlength="50" placeholder="Saves Your Account Information">
                    <div class="invalid-feedback">Please make sure provided password is at least 8 characters long.</div>
                  </div>
                <!-- /Password -->

                <!--Save info -->
                  <!-- <div class="custom-control custom-checkbox">
                    <input id="chkout-saveInfo" type="checkbox" name="saveInfo" class="custom-control-input">
                    <label class="custom-control-label" for="chkout-saveInfo">Save info for next time</label>
                  </div> -->
                <!--/Save info -->
              <!-- /Account Creation -->


              <!-- Submit -->
                <hr class="mb-4">
                <div class="g-recaptcha" data-sitekey="6LcQz6kZAAAAAOOqpL7L8cvxxArepS35u-kTI5Ek"></div>
                <button class="btn btn-primary btn-block mt-4" id="submitUserInfo" name="submitUserInfo" value>Payment Method</button>
              <!-- /Submit -->
            </form>
          <!-- /Form -->
          <script>
          // Client-side Validation
            // Fields Empty
              // Example starter JavaScript for disabling form submissions if there are invalid fields
              (function() {
                'use strict';
                window.addEventListener('load', function() {
                  // Fetch all the forms we want to apply custom Bootstrap validation styles to
                  var forms = document.getElementsByClassName('needs-validation');
                  // Loop over them and prevent submission
                  var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                      if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                      }
                      form.classList.add('was-validated');
                    }, false);
                  });
                }, false);
              })();
            // /Fields Empty

            // Int Check
              function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
              }
            // /Int Check
          // /Client-side Validation
          </script>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
  <nav class="footer" style='text-align: center; bottom: 0; max-width: 1300px;'>
    <a class="footer-link" href="https://fortisureit.com/">FortisureIT</a>
    <a class="footer-link" href="https://food.fortisureit.com/">Food Partners</a>
  </nav>
<!-- /Footer -->

<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script> 
<script src="View/Public/JS/charge.js"></script>

</body>
</html>