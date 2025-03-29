<?php


if (isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];
    setcookie('language', $_POST['language'], time() + (86400 * 30), "/"); // Store for 30 days
    echo json_encode(['status' => 'success', 'language' => $_POST['language']]);
    exit;
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
.content-box{background-color: #0000;filter: blur(2px);}      
.content-box .content-body{background-color: #0B6C4B;border-top-left-radius: 30px;border-top-right-radius: 30px;color: white;height: 600px;}
.content-box .content-body form .form-control{border-radius: 30px;background-color: #3C896F;}
.content-box .content-body form .form-control::placeholder{color: white;}
.content-box .content-body form button.voucher{background-color: white;width: 100%;max-width: 280px;margin: 0 auto;display: flex;align-items: center;justify-content: center;border-radius: 30px;color: #0B6C4B;font-weight: 500;}
.splash-area{position: fixed;bottom: 0;background-color: white;width: 100%;border-top-left-radius: 30px;border-top-right-radius: 30px;}
.splash-content{align-items: center;margin: 0 auto;}
.btn-lang {
            background-color: #0B6C4B;
            color: white;
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
            border: 2px solid #0B6C4B;
            color: #0B6C4B;
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
    <section class="d-md-none d-block">
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
                <h3 class="mt-4 mb-3">Please select your<br> preferred language</h3>
                <form method="POST" id="languageForm">
                    <button type="button" class="btn btn-lang my-2" onclick="setLanguage('English')">English</button>
                    <button type="button" class="btn btn-lang-outline my-2" onclick="setLanguage('Hindi')">Hindi</button>
                </form>
                <!-- <div class="button-area mt-2">
                    <button class="btn btn-lang my-2">English</button>
                    <button class="btn btn-lang-outline my-2">Hindi</button>
                </div> -->
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function setLanguage(lang) {
    fetch('select_lang.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'language=' + lang
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload(); // Reload page to apply the language change
        }
    });
}
</script>
</body>
</html>
