<?php
session_start();
$phoneNumber = $_SESSION['phoneNumber'];
require_once './config/config.php';  

$db = getDbInstance();

$db->where('phone', $phoneNumber);
$customer = $db->getOne('user_info', ['name']); // Only fetch the 'name' column

if ($customer) {
    $customerName = $customer['name'];
} 

$numCustomers = $db->get("customer_vouchers");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jeena Sikho Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        ul li{list-style: none;}
        ul{padding-left: 0;}
       
.choose-voucher-area{background-image: url(./assets/images/voucher-bg.png);background-repeat: no-repeat;background-size: 100% 100%;width: 100%;height: 100%;padding-bottom: 50px;}
   .choose-voucher-area h3{color: white;} 
   .voucher-list ul li{margin-top: 15px;}
   .btn-lang {
            background-color: white;
            color: #0B6C4B;
            font-weight: bold;
            border-radius: 30px;
            padding: 14px 20px;
            width: 100%;
            max-width: 250px;
            border: none;
            text-align: center;
            font-size: 16px;
        }
        .btn-lang-outline {
            border: 2px solid white;
            color: white;
            font-weight: bold;
            border-radius: 30px;
            padding: 14px 20px;
            width: 100%;
            max-width: 250px;
            text-align: center;
            font-size: 16px;
            background: transparent;
        }
    </style>
</head>
<body>
<section class="d-md-none d-block ">
    <div class="choose-voucher-area second-section">
        <div class="container-fluid">
            <div class="voucher-list text-center pt-5">
                <img src="" id="selectedVoucherImage"  alt="video-consult" class="video-vouch img-fluid pb-3"> 
                <div class="expirt-date">
                    <p>Expiry Date: 01 Apr 2025</p>
                </div>
                <button class="btn btn-lang my-2" id="redeemBtn">Redeem</button>
                <button class="btn btn-lang-outline my-2" id="goBackBtn">Go Back</button>
            </div>
        </div>
    </div>
   </section>
   <section class="d-md-none d-block ">
    <div class="choose-voucher-area first-section">
        <div class="container-fluid">
            <h3 class="text-center pt-3">Choose Your Voucher <?php echo $customerName?></h3>
            <div class="voucher-list text-center">
                <ul>
                    <?php
                    foreach ($numCustomers as $customer) {
                        $voucherName = $customer['id'];
                        $voucherImage = $customer['voucher_photo'];
                        $voucherParaImage = $customer['voucher_para_pic'];
                        echo '<li data-voucher-image="'.$voucherParaImage.'"><a href="#"><img src="./assets/images/'.$voucherImage.'" alt="'.$voucherName.'" class="img-fluid"></a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
   </section>
  

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
        $(document).ready(function(){
            $('.second-section').hide();
            // When a voucher is clicked
            $('.voucher-list ul li').click(function(e) {
                e.preventDefault();
                
                var voucherImage = $(this).data('voucher-image');
                
                // Set the image in the second section
                $('#selectedVoucherImage').attr('src', './assets/images/' + voucherImage);
                
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
                $.ajax({
                    url: 'redeem_voucher.php',
                    method: 'POST',
                    data: formData,
                    success: function(response){}
                })
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
