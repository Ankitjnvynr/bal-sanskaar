<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GIEO Gita-Bal Sanskaar Yojna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/header.css">
</head>

<body class="bg-warning-subtle">

    <?php
    $logoPath = 'imgs/logo.png';
    $loginBtnPath = 'login/';
    include 'parts/_header.php';

    ?>


    <div class="container">
        <div style="height:70vh" class="d-flex justify-content-center align-items-center">
            <div style="background:#fcfdfc;" class="card text-center p-3 ">
                <img width="100px" class="m-auto"
                    src="https://gifdb.com/images/high/animated-green-verified-check-mark-k3et2jz52jyu2v22.gif" alt="">
                <p class="h4 fw-bolder text-success">
                    Success!
                </p>
                <p class="text-muted">Your Registration has completed.</p>
                <p><a href="./" class="btn btn-success mt-2">OK</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>