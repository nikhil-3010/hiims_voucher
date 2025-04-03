<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
 function setLanguage(lang) {
   
            sessionStorage.setItem('language', lang);
            $('#language-selection').hide();
            $('#phone-number-section').show();
        }
               
        $(document).ready(function () {
            $('#otpForm').on('submit', function (e) {
                e.preventDefault();
                const phoneNumber = $('#phoneNumber').val().trim();
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
                            $('#phone-number-section').hide();
                            $('#otp-section').show();
                            
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
                    alert('Please enter a valid 4-digit OTP.');
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

                            $('#otp-section').hide();
                            $('#form-section').show();
                        }else {
            $('#responseMessage').text('User data not found. Please try again.');
        }
                    }
                });
                            } else {
                                alert(res.message);
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
                    const customerName = voucherInfo.customerName;
                    const vouchers = voucherInfo.voucherList;

                    $('#voucher-title').text('Choose Your Voucher ' + customerName);

                    let voucherHTML = '';
                    vouchers.forEach(voucher => {
                        voucherHTML += `
                            <li data-voucher-image="${voucher.voucher_para_image}" 
                                data-voucher-id="${voucher.voucher_id}">
                                <a href="#">
                                    <img src="./assets/images/${voucher.voucher_image}" 
                                         alt="${voucher.voucher_id}" 
                                         class="img-fluid">
                                </a>
                            </li>
                        `;
                    });

                    $('#voucher-list').html(voucherHTML);

                    $('#form-section').hide();
                    $('#voucher-section').show();
                } else {
                    alert(res.message);
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
            $('.voucher-list ul li').click(function(e) {
                e.preventDefault();
                
                var voucherImage = $(this).data('voucher-image');
                var voucherExpiry = $(this).data('voucher-expiry');
                var voucherName = $(this).data('voucher-id');

                selectedVoucherID = $(this).find('a img').attr('alt');

                var formattedDate = new Date(voucherExpiry);
                var options = { day: 'numeric', month: 'long', year: 'numeric' };
                var formattedExpiry = formattedDate.toLocaleDateString('en-US', options);
                
                // Set the image in the second section
                $('#selectedVoucherImage').attr('src', './assets/images/' + voucherImage);
                $('#selectedVoucherImage').attr('alt',  voucherName);
                $('#exp_date').text('Expiry Date: ' + formattedExpiry);
                
                // Hide the first section and show the second section
                $('.first-section').fadeOut(500, function() {
                    $('.second-section').fadeIn(500);
                });
            });

            // Go back button functionality
            $('#goBackBtn').click(function() {
                // Show the first section and hide the second section
                $('.second-section').fadeOut(500, function() {
                    $('.first-section').fadeIn(500);
                });
            });

            $('#redeemBtn').click(function() {
                if (!selectedVoucherID) {
                    alert('No voucher selected!');
                    return;
                }

                $.ajax({
                    url: 'redeem_voucher.php',
                    method: 'POST',
                    data: { voucherID: selectedVoucherID },
                    success: function(response){
                        var result = JSON.parse(response);
                        if (result.success) {
                            
                            alert('Redeem Code Generated: ' + result.redeem_code);
                        } else {
                            alert(result.message);
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