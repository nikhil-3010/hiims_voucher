
<body>
    <section class="d-md-none d-block" id="firstform">
        <div class="logo-area">
        <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="logo" class="logo-img img-fluid">
    </div>
            <div class="content-box mt-3 mb-3">
                <div class="text-center">
            </div>
            </div>
            <div class="splash-area">
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
    <section class="d-md-none d-block" id="otpSection" style="display:none;">
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
            <div class="splash-area-otp">
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
                    <button class="btn btns-lang my-2" id="verifyOtpBtn">Verify</button>
                </div>
            </div>
        </div>
    </section>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
