<?php

session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// $selectedLanguage = 'English';

if (!isset($_SESSION['language'])) {
    if (isset($_COOKIE['language'])) {
        $_SESSION['language'] = $_COOKIE['language'];
    }  
}


$selectedLanguage = isset($_SESSION['language']);

include BASE_PATH.'/includes/coupon_header.php';
?>
<body>
<section class="d-md-none " id="language-selection" >
            <div class="content-box mt-3 mb-3">
                <div class="text-center">
                <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="logo" class="logo-img img-fluid">
            </div>
                <div class="content-body mt-4 p-3">
                    <div class="container-fluid">
                        <h3 class="text-center">Please enter your <br>general information &<br> address</h3>
                        <form>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail2" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp" placeholder="Enter Phone Number">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail3" class="form-label">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail3" aria-describedby="emailHelp" placeholder="Enter Email">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail4" class="form-label">Pin code</label>
                                <input type="number" class="form-control" id="exampleInputEmail4" aria-describedby="emailHelp" placeholder="Enter Pin code">
                              </div>
                            <button type="submit" class="btn btn-custom voucher w-100">Get Your Voucher</button>
                        </form>
                        <div class="info mt-3">
                            <img src="./assets/images/Mask group (2).png" alt="more information" class="more-info img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="splash-area">
            <div class="splash-content text-center pt-3">
                <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="splash-logo" class="spalsh-img img-fluid">
                <h2 class="mt-4 mb-3">Please select your<br> preferred language</h2>
                <form method="POST" id="languageForm">
                    <button type="button" class="btn btn-langs my-2" onclick="setLanguage('English')">English</button>
                    <button type="button" class="btn btn-langs-outline my-2" onclick="setLanguage('Hindi')">Hindi</button>
                </form>
            </div>
        </div>
    </section>

    <!-- second-view -->
    <section class="d-md-none " id="phone-number-section" style="display:none;">
        <div class="logo-area">
        <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="logo" class="logo-img img-fluid">
    </div>
            <div class="content-box mt-3 mb-3">
                <div class="text-center">
            </div>
            </div>
            <div class="splash-areaa">
                <div class="container-fluid">
            <div class="splash-content pt-3">
                <h2 class="sign-in-text text-center">Sign In</h2>
                <form  id="otpForm" >
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                        <input type="telephone" class="form-control" name="phoneNumber"  id="phoneNumber" aria-describedby="emailHelp" placeholder="Enter Phone Number" minlength="10" maxlength="10" required>
                      </div>
                      <div class="button-area text-center mt-3">
                          <button type="submit" class="btn btns-lang my-2" >Get OTP</button>
                        </div>
                    </form>

                     
            </div>
            </div>
        </div>
    </section>
    <div id="responseMessage" style="color: red; text-align: center;"></div>
    <section class="d-md-none " id="otp-section" style="display:none;">
            <div class="content-box mt-3 mb-3">
                <div class="text-center">
                <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="logo" class="logo-img img-fluid">
            </div>
                <div class="content-body mt-4 p-3">
                    <div class="container-fluid">
                        <h3 class="text-center">Please enter your <br>general information &<br> address</h3>
                        <form>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Phone Number">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Pin code</label>
                                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Pin code">
                              </div>
                            <button type="submit" class="btn btn-custom voucher w-100">Get Your Voucher</button>
                        </form>
                        <div class="info mt-3">
                            <img src="./assets/images/Mask group (2).png" alt="more information" class="more-info">
                        </div>
                    </div>
                </div>
            </div>
            <div class="splash-area">
            <div class="splash-content text-center pt-3">
                <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="splash-logo" class="spalsh-img img-fluid">
                <p class="otp-text mt-4">We have sent one time password on<br> your mobile please enter bellow</p>
                <div class="text-center">
                    <div class="otp-container">
                    <input type="text" maxlength="1" class="otp-input" id="otp1">
                    <input type="text" maxlength="1" class="otp-input" id="otp2">
                    <input type="text" maxlength="1" class="otp-input" id="otp3">
                    <input type="text" maxlength="1" class="otp-input" id="otp4">
                    </div>
                </div>
                <div class="button-area mt-3">
                    <button class="btn btn-langs my-2" id="verifyOtpBtn">Verify</button>
                </div>
            </div>
        </div>
    </section>


    <!-- signup form -->
    <section class="d-md-none" id="form-section" style="display:none;">
    <div class="content-boxs mt-3 mb-3">
        <div class="text-center">
            <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="logo" class="logo-img img-fluid">
        </div>
        <div class="content-body mt-4 p-3">
            <div class="container-fluid">
                <h2 class="text-center">Please enter your <br>general information &<br> address</h2>
                <form id="info-form">
                    <div class="mb-3">
                        <label for="infoname" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="infoname" placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="infophone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" id="infophone" >
                    </div>
                    <div id="responseMessage" style="color: red; text-align: center;"></div>
                    <div class="mb-3">
                        <label for="infoemail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="infoemail" placeholder="Enter Email">
                    </div>
                    <div class="mb-3">
                        <label for="infopincode" class="form-label">Pin code</label>
                        <input type="number" class="form-control" name="pincode" id="infopincode" placeholder="Enter Pincode" min="000001" max="999999">
                    </div>
                    <button type="submit" class="btn btn-custom vouchers w-100">Get Your Voucher</button>
                </form>
                <div class="info mt-3">
                    <img src="./assets/images/Mask group (2).png" alt="more information" class="more-info img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- choose voucher -->


   <section class="d-md-none" id="voucher-section" style="display:none;">
    <div class="choose-voucher-area first-section">
        <div class="container-fluid">
            <h2 class="text-center pt-3" style="color:lightgrey;"></h2>
            <div class="voucher-list text-center">
                <ul id="voucher-list">
                   
                </ul>
            </div>
        </div>
    </div>
   </section>
    
   <section class="d-md-none" id="choose-voucher-section" style="display:none;">
    <div class="choose-voucher-area second-section">
        <div class="container-fluid">
            <div class="voucher-list text-center pt-5">
                <img src="" id="selectedVoucherImage"  alt=""  class="video-vouch img-fluid pb-3"> 
                <h3 class="text-center pt-3" style="color:#3c854f;"></h3>
                <div class="expirt-date">
                    <p id="exp_date">Expiry Date: </p>
                </div>
                <button class="btn btn-lang my-2" id="redeemBtn">Redeem</button>
                <button class="btn btn-lang-outline my-2" id="goBackBtn">Go Back</button>
            </div>
        </div>
    </div>
   </section>




</body>

<?php include BASE_PATH.'/includes/coupon_footer.php'; ?>
