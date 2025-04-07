<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function setLanguage(lang) {
            sessionStorage.setItem('language', lang);
            globalThis.lang = lang;

            if (lang == 'Hindi'){
                $('.hin').show();
                $('.hin input, .hin btn').prop('disabled', false);
                $('.eng').hide();
                $('.eng input, .eng btn').prop('disabled', true);
            }
            else if (lang == 'English'){
                $('.eng').show();
                $('.eng input, .eng btn').prop('disabled', false);
                $('.hin').hide();
                $('.hin input, .hin btn').prop('disabled', true);
            }
                       
            $('#language-selection').fadeOut(500, function() {
            $('#phone-number-section').fadeIn(500);
            });
        }
               
        $(document).ready(function () {
            if(sessionStorage.getItem('language') && sessionStorage.getItem('phoneNumber') ) {
            // $('#language-selection').fadeOut(500, function() {
            //     $('#voucher-section').fadeIn(500);
            // });
            
            loadVouchers();
            }

            $('#otpForm').on('submit', function (e) {
                e.preventDefault();
                var phoneNumber;
                if(lang == 'English'){
                phoneNumber = $('#phoneNumber').val().trim();}
                else{
                phoneNumber = $('#hphoneNumber').val().trim();
                }
                sessionStorage.setItem('phoneNumber', phoneNumber);

                if (phoneNumber.length !== 10) {
                    alert('Please enter a valid 10-digit phone number.');
                    return;
                }

                $.ajax({
                    url: 'request_otp.php',
                    method: 'POST',
                    data: { phoneNumber: phoneNumber },
                    
                    success: function (res) { 
                        if (res.success) {
                        $('#phone-number-section').fadeOut(500, function() {
                        $('#otp-section').fadeIn(500);
                        });
                            
                            
                        } else {
                            $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
                        }
                    }
                });
            });

            $('#verifyOtpBtn').on('click', function () {
                let otp = '';
                $('.otp-input').each(function () {
                    otp += $(this).val();
                });

                if (otp.length !== 4) {
                    $('#responseMessage').html('<div class="alert alert-danger">' + 'Please enter a valid 4-digit OTP.' + '</div>');
                    return;
                }

                $.ajax({
                    url: 'verify_otp.php',
                    method: 'POST',
                    data: { otp: otp },
                    success: function (res) {
                        
                            if (res.success) {
                                $.ajax({
                    url: 'fetch_users.php',
                    method: 'POST',
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            const userInfo = res.data;
                            $('#infoname').val(userInfo.name);
                            $('#infoemail').val(userInfo.email);
                            $('#infopincode').val(userInfo.pincode);
                            $('#infophone').val(sessionStorage.getItem('phoneNumber'));

                            
                            $('#otp-section').fadeOut(500, function() {
                        $('#form-section').fadeIn(500);
                        });
                        }else {
            $('#responseMessage').text('User data not found. Please try again.');
        }
                    }
                });
                            } else {
                                $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
                            }
                        
                    }
                });
            });

            $('#info-form').on('submit', function(e){
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                    url: 'submit_info.php',
                    method: 'POST',
                    data: formData,
                    success: function(response){
                        const res = typeof response === "string" ? JSON.parse(response) : response;
                    if (res.success) {
                        loadVouchers();
                    } else {
                        $('#responseMessage').html('<span style="color: red;">' + res.message + '</span>');
                    }
        
                        }
                    })
                });

        
function loadVouchers() {
    $.ajax({
        url: 'choose_voucher.php',
        method: 'POST',
        success: function(response) {
            try {
                const res = JSON.parse(response);

                if (res.success) {
                    const voucherInfo = res.data;
                    const customer = voucherInfo.customerName;
                    const vouchers = voucherInfo.voucherList;
                    const redeemCode = voucherInfo.redeemCode;

                    $('#voucher-title').text('Choose Your Voucher ' + customer.name);

                    let voucherHTML = '';
                    vouchers.forEach(voucher => {

                        const hasRedeemCode = redeemCode && voucher.voucher_id == redeemCode.coupon_id; 

                        const wlang = sessionStorage.getItem('language');

                        if(wlang == 'English'){
                            voucherHTML += `
                            <li data-voucher-image="${voucher.voucher_para_image}" 
                            data-voucher-id="${voucher.voucher_id}"
                            data-expiry-date="${hasRedeemCode ? redeemCode.expiry_date : ''}"
                            data-voucher-code="${hasRedeemCode ? redeemCode.coupon_code : ''}"
                            data-cust-id="${customer.id}">
                            <a href="#">
                                <img src="./assets/images/${voucher.voucher_image}" 
                                    alt="${voucher.voucher_id}" 
                                    class="img-fluid">
                            </a>
                            </li>
                        `;
                        }else if(wlang == 'Hindi'){
                            voucherHTML += `
                            <li data-voucher-image="${voucher.voucher_para_image_hin}" 
                            data-voucher-id="${voucher.voucher_id}"
                            data-expiry-date="${hasRedeemCode ? redeemCode.expiry_date : ''}"
                            data-voucher-code="${hasRedeemCode ? redeemCode.coupon_code : ''}"
                            data-cust-id="${customer.id}">
                            <a href="#">
                                <img src="./assets/images/${voucher.voucher_image_hin}" 
                                    alt="${voucher.voucher_id}" 
                                    class="img-fluid">
                            </a>
                            </li>`;}
                    });

                    $('#voucher-list').html(voucherHTML);

                    $('#form-section').fadeOut(500, function() {
                        $('#voucher-section').fadeIn(500);
                        });
                    
                } else {
                    $('#voucher-section').hide()
                        $('#language-selection').fadeIn(500);
                        
                    // $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            } catch (error) {
                console.error('Error parsing JSON from choose_voucher.php:', error);
            }
        },
        error: function() {
            alert('Failed to load vouchers. Please try again.');
        }
    });
}

            var selectedVoucherID = null;
            // When a voucher is clicked
            $('#voucher-list').on('click', 'li', function(e) {
                e.preventDefault();
                var voucherImage = $(this).data('voucher-image');
                var vouchercode = $(this).data('voucher-code');
                var voucheredate = $(this).data('expiry-date');
                var c_id = $(this).data('cust-id');


                selectedVoucherID = $(this).find('a img').attr('alt');
                selectedCustomerID = c_id;
                              

                var formattedDate = new Date(voucheredate);
                var options = { day: 'numeric', month: 'long', year: 'numeric' };
                var formattedExpiry = formattedDate.toLocaleDateString('en-US', options);
                
                // Set the image in the second section
                $('#selectedVoucherImage').attr('src', './assets/images/' + voucherImage);
                $('#selectedVoucherImage').attr('alt',  selectedVoucherID);
                if(vouchercode !== ''){
                    $('#redid').val(vouchercode);
                    $('#exp_date').text('Expiry Date: ' + formattedExpiry);
                    $('#redeemBtn').hide();
                }
                
                
                // Hide the first section and show the second section
                $('#voucher-section').fadeOut(500, function() {
                    $('#choose-voucher-section').fadeIn(500);
                });
            });

            // Go back button functionality
            $('#goBackBtn').click(function() {
                // Show the first section and hide the second section
                $('#choose-voucher-section').fadeOut(500, function() {
                    $('#voucher-section').fadeIn(500);
                });
            });


            $('#redeemBtn').click(function(e) {
                e.preventDefault();
                if (!selectedVoucherID) {
                    alert('No voucher selected!');
                    return;
                }

                var enteredCode = $('#redid').val().trim();

                if (!enteredCode) {
                    alert('Please enter a coupon code!');
                    return;
                }

                $.ajax({
                    url: 'redeem_voucher.php',
                    method: 'POST',
                    data: { 
                        voucherID: selectedVoucherID,
                        enteredCode: enteredCode , 
                        customerID: selectedCustomerID
                     },
                    success: function(response){
                        var result = JSON.parse(response);
                        if (result.success) {
                            $('#responseMessage').html('<span style="color: green;">' + result.message + '</span>');
                            $('#exp_date').text('Expiry Date: ' + result.expiry_date);
                        } else {
                            $('#responseMessage').html('<span style="color: red;">' + result.message + '</span>');
                            
                        }
                    }
                });
            });

            // Handle input focus for OTP boxes
            $('.otp-input').on('input', function () {
                if (this.value.length === 1) {
                    $(this).next('.otp-input').focus();
                }
            });

            $('.otp-input').on('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value) {
                    $(this).prev('.otp-input').focus();
                }
            });
        });

    </script>
   
</body>
</html>