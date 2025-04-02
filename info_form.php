<?php
require_once './config/config.php';  // This should contain your database connection and MysqliDb setup

session_start();
if (isset($_SESSION['phoneNumber'])) {
    $phoneNumber = $_SESSION['phoneNumber'];

    $db = getDbInstance(); // Make sure your config file defines this function properly
    
    $db->where('phone', $phoneNumber);
    $existingUser = $db->getOne('user_info', ['name', 'email', 'pincode']);

    if (!$existingUser) {
        $existingUser = ['name' => 'Enter Name', 'email' => 'Enter Email', 'pincode' => 'Enter Pincode']; // Initialize as empty if not found
    }
}else{
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jeena Sikho Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      
.content-box .content-body{background-color: #0B6C4B;border-top-left-radius: 30px;border-top-right-radius: 30px;color: white;height: 600px;}
.content-box .content-body form .form-control{border-radius: 30px;background-color: #3C896F;}
.content-box .content-body form .form-control::placeholder{color: white;}
.content-box .content-body form button.voucher{background-color: white;width: 100%;max-width: 280px;margin: 0 auto;display: flex;align-items: center;justify-content: center;border-radius: 30px;color: #0B6C4B;font-weight: 500;}
    </style>
</head>
<body>
    <section class="d-md-none d-block">
            <div class="content-box mt-3 mb-3">
                <div class="text-center">
                <img src="./assets/images/final_jeena_sikho_logo 1.png" alt="logo" class="logo-img img-fluid">
            </div>
                <div class="content-body mt-4 p-3">
                    <div class="container-fluid">
                        <h3 class="text-center">Please enter your <br>general information &<br> address</h3>
                        <form id="info-form">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="name" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo htmlspecialchars($existingUser['name']); ?>"
                                value="<?php echo isset($existingUser['name']) ? htmlspecialchars($existingUser['name']) : ''; ?>">
                                
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                                <input type="telephone" class="form-control" name="phone" id="exampleInputEmail2" aria-describedby="emailHelp" placeholder="<?php echo isset($phoneNumber) ? $phoneNumber : 'Enter Phone Number'?>" value="<?php echo isset($phoneNumber) ? $phoneNumber : ''?>"
                                 readonly>
                              </div>
                              <div id="responseMessage" style="color: red; text-align: center;"></div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail3" aria-describedby="emailHelp" placeholder="<?php echo htmlspecialchars($existingUser['email']); ?>"
                                value="<?php echo htmlspecialchars($existingUser['email']); ?>">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Pin code</label>
                                <input type="number" class="form-control" name="pincode" id="exampleInputEmail4" aria-describedby="emailHelp" placeholder="<?php echo htmlspecialchars($existingUser['pincode']); ?>"
                                value="<?php echo htmlspecialchars($existingUser['pincode']); ?>" min="000001" max="999999">
                              </div>
                            <button type="submit" class="btn btn-custom voucher w-100">Get Your Voucher</button>
                        </form>
                        <div class="info mt-3">
                            <img src="./assets/images/Mask group (2).png" alt="more information" class="more-info img-fluid">
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
                $('#info-form').on('submit', function(e){
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: 'submit_info.php',
                        method: 'POST',
                        data: formData,
                        success: function(response){
                            try {
            const res = typeof response === "string" ? JSON.parse(response) : response;
            if (res.success) {
                
                    window.location.href = 'choose_voucher.php';
            } else {
                $('#responseMessage').html('<span style="color: red;">' + res.message + '</span>');
            }
        } catch (error) {
            console.error("Error parsing response:", error);
            
        }
                        }
                    })
                });
        });
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
