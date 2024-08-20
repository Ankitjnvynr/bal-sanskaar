<?php
$sub = false;
session_start();
if (isset($_SESSION['loggedin'])) {
    if (isset($_SESSION['phone'])) {
        header('Location: ../login');
        exit;
    }

    header("location: dashboard.php?data=student");

    exit;
}
include("../config/_db.php");
$msg = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sub = true;
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_user WHERE  username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $logged = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['intro'] = true;
                $_SESSION['userType'] = 'admin';
                $_SESSION['isAdmin'] = true;
                header("location: dashboard.php?data=student");
                exit;
            } else {
                $msg = "Password not match";
            }
        }
    } else {
        $msg = "Wrong username";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIEO Gita : Admin login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/login.css">
    <style>
        body {
            margin: 10px;
            background: #f7e092;
            overflow-x: hidden;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
        }

        .logo {
            top: -75px;
            width: 150px;
            /* border: 2px solid red; */
            border-radius: 50%;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="leaf"></div>
    <div style="--delay:1s; --x-pos:10%;" class="leaf"></div>
    <div style="--delay:2s; --x-pos:70%;" class="leaf"></div>
    <div style="--delay:3s; --x-pos:80%;" class="leaf"></div>
    <div style="--delay:4s; --x-pos:30%;" class="leaf"></div>
    <div style="--delay:5s; --x-pos:90%;" class="leaf"></div>


    <?php
    if ($msg) {
        echo '
        <div style="top:2%;" class="container position-absolute ">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Alert!</strong> ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        ';
    }
    ?>


    <div style="width:90%; max-width:400px " class="container  d-flex justify-content-center align-items-center shadow p-4 py-5 rounded bg-warning-subtle rounded-xl position-relative ">
        <div class="logo position-absolute shadow">
            <img style="width:100%" src="../imgs/Logo.png" alt="GIEO gita logo">
        </div>
        <form class="relative w-100 mt-5 overflow-hidden " method="POST" action="">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="<?php if ($sub)
                                                                    echo $username; ?>" id="username" name="username" required placeholder="name@example.com">
                <label for="username">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control " id="password" name="password" required placeholder="Password">
                <i id="passwordicon" class="fa-regular fa-eye position-absolute end-0 top-50 end-0 translate-middle-y fs-5 mr-3 translate-x-3 text-danger pr-3" style="margin-right: 10px; cursor: pointer;"></i>
                <label for="password">Password</label>

            </div>
            <div class="text-center pt-2">
                <button type="submit" class="btn btn-danger">Log In</button>
            </div>
            <div class="text-center mt-2 ">
                <a target="_blank" class="text-danger link-underline link-underline-opacity-0 fw-bold" href="../index.php">
                    <i class="fa-solid fa-house"></i>
                    Homepage->
                </a>
            </div>
            <div class="text-center text-danger mt-1"><a class="btn" href="../login">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="mx-2 fw-bold">Are you Teacher ? click</span></a>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        let passwordicon = document.getElementById('passwordicon')
        let password = document.getElementById('password')

        passwordicon.addEventListener('click', (e) => {
            e.target.classList.toggle("fa-eye-slash");
            e.target.classList.toggle("fa-eye");
            password.type = (password.type == 'text') ? 'password' : 'text';
            console.log(e.target);
        });
    </script>
</body>

</html>