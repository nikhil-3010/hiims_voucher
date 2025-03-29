<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jeena Sikho Form</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
.content-box{background-color: #0000;filter: blur(2px);}      
.content-box .content-body{background-color: #0B6C4B;border-top-left-radius: 30px;border-top-right-radius: 30px;color: white;height: 600px;}
.content-box .content-body form .form-control{border-radius: 30px;background-color: #3C896F;}
.content-box .content-body form .form-control::placeholder{color: white;}
.content-box .content-body form button.voucher{background-color: white;width: 100%;max-width: 280px;margin: 0 auto;display: flex;align-items: center;justify-content: center;border-radius: 30px;color: #0B6C4B;font-weight: 500;}
.splash-area{position: fixed;bottom: 0;background-color: #0B6C4B;width: 100%;border-top-left-radius: 30px;border-top-right-radius: 30px;}
.splash-area-otp{position: fixed;bottom: 0;background-color: white;width: 100%;border-top-left-radius: 30px;border-top-right-radius: 30px;}
.splash-content{align-items: center;margin: 0 auto;}
.btn-lang {
            background-color: white;
            color: #0b5935;
            font-weight: bold;
            border-radius: 30px;
            padding: 10px 20px;
            width: 100%;
            max-width: 260px;
            border: none;
            text-align: center;
            font-size: 16px;
        }
        .otp-text{color: #717171;font-size: 18px;}
        .otp-input {
            width: 60px;
            height: 54px;
            text-align: center;
            font-size: 24px;
            border: 2px solid #ccc;
            border-radius: 26px;
            outline: none;
            background: transparent;
            color: black;
        }
        .otp-input:focus {
            border-color: #0b5935;
            outline: none;
        }
        .sign-in-text{color: white;}
        .logo-area{display: flex;margin: 0 auto;align-items: center;justify-content: center;text-align: center;margin-top: 40%;}
         form .form-control{border-radius: 30px;background-color: #3C896F;}
        form .form-control::placeholder{color: white;}
        .form-label{color: white;}
    </style>
</head>
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
                          <button type="submit" class="btn btn-lang my-2" >Get OTP</button>
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
                    <button class="btn btn-lang my-2" id="verifyOtpBtn">Verify</button>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#otpForm').on('submit', function(e) {
                e.preventDefault();

                const phoneNumber = $('#phoneNumber').val().trim();
                if (phoneNumber.length !== 10) {
                    alert('Please enter a valid 10-digit phone number.');
                    return;
                }


                $.ajax({
                    url: 'request_otp.php',
                    method: 'POST',
                    data: { phoneNumber: phoneNumber },
                    success: function(response) {
        try {
            const res = typeof response === "string" ? JSON.parse(response) : response;
            if (res.success) {
                $('#otpSection').show();
                $('#firstform').hide();
                // $('#responseMessage').html('<span style="color: green;">' + res.message + ' (For testing: ' + res.otp + ')</span>');
            } else {
                $('#responseMessage').html('<span style="color: red;">' + res.message + '</span>');
            }
        } catch (error) {
            console.error("Error parsing response:", error);
            $('#responseMessage').html('<span style="color: red;">Invalid response from server.</span>');
        }
    }
                });
            });

            $('#verifyOtpBtn').on('click', function() {
                let otp = '';
                $('.otp-input').each(function() {
                    otp += $(this).val();
                });
                
                $.ajax({
                    url: 'verify_otp.php',
                    method: 'POST',
                    data: { otp: otp },
                    success: function(response) {
            try {
                const res = typeof response === "string" ? JSON.parse(response) : response;
                if (res.success) {
                    $('#responseMessage').html('<div class="alert alert-success">' + res.message + '</div>');
                    window.location.href = 'info_form.php';
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            } catch (error) {
                console.error("Error parsing response:", error);
                $('#responseMessage').html('<div class="alert alert-danger">Invalid response from server.</div>');
            }
        }
                });
            });
        });
    </script>
    <script>
        const phoneNumberInput = document.getElementById("phoneNumber");
        const otpSection = document.getElementById("otpSection");

        // Allow only numbers in phone input
        phoneNumberInput.addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Remove non-digit characters
        });

        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
        input.addEventListener('input', function (e) {
        if (this.value.length === 1) {
        if (index < inputs.length - 1) {
        inputs[index + 1].focus(); // Move to the next input
        }
        }
        });

        input.addEventListener('keydown', function (e) {
        if (e.key === "Backspace" && this.value === '') {
        if (index > 0) {
        inputs[index - 1].focus(); // Move to the previous input
        }
        }
        });
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
