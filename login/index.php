<?php
require_once '../config/_db.php';

session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['userType'] == 'admin') {
        header('Location: ../admin/');
        exit;
    } else {
        header('Location: dashboard.php?data=student');
        exit;
    }
}
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username']) || $_POST['username'] == "") {
        $msg = "Please enter username";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepared statement to check user
        $stmt = $conn->prepare("SELECT * FROM teachers WHERE `phone` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Use password_verify for checking hashed passwords
                if (password_verify($password, $row['userpassword'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['country'] = $row['country'];
                    $_SESSION['state'] = $row['state'];
                    $_SESSION['district'] = $row['district'];
                    $_SESSION['tehsil'] = $row['tehsil'];
                    $_SESSION['userCenter'] = $row['center'];

                    $typearr = explode(",", $row['teacher_type']);

                    if (in_array('State Head', $typearr)) {
                        $_SESSION['userType'] = 'State Head';
                    }elseif(in_array('City Head', $typearr)){
                        $_SESSION['userType'] = 'City Head';
                    }elseif(in_array('Teacher', $typearr)){
                        $_SESSION['userType'] = 'Teacher';
                    }else{
                        $_SESSION['userType'] = 'Teacher1';
                    }

                    $msg = "Teacher exists!";
                    header('Location: dashboard.php?data=student');
                    exit;
                } else {
                    $msg = "Wrong password!";
                }
            }
        } else {
            $msg = "Phone number does not exist";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GIEO Gita-Bal Sanskaar Yojna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/login.css">
    <style>
        .form-item {
            flex: 1 0 230px;
        }

        .fs-7 {
            font-size: 0.9rem;
        }

        .h-full {
            height: 100%;
            min-height: 97vh;
        }
    </style>
</head>

<body class="bg-warning-subtle">
    <div class="leaf"></div>
    <div style="--delay:1s; --x-pos:10%;" class="leaf"></div>
    <div style="--delay:2s; --x-pos:70%;" class="leaf"></div>
    <div style="--delay:3s; --x-pos:80%;" class="leaf"></div>
    <div style="--delay:4s; --x-pos:30%;" class="leaf"></div>
    <div style="--delay:5s; --x-pos:90%;" class="leaf"></div>
    <div class="container h-full d-flex align-items-center justify-content-center">
        <!-- Login Form -->
        <div id="loginForm" style="background:transparent; backdrop-filter:blur(5px);" class="card p-4 shadow-sm col-md-4">
            <div class="text-center fw-bold my-2 text-danger fs-3">Login</div>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Phone</label>
                    <input type="text" value="<?php echo isset($_GET['phone']) ? $_GET['phone'] : '';
                                                echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>" class="form-control" id="username" name="username" onkeypress="return onlyDigits(event)" size="10" minlength="10" maxlength="10" placeholder="Enter phone no as username" />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-danger">Login</button>
                </div>
                <div class="email-help text-danger text-center"><?php echo $msg; ?></div>
            </form>
            <div class="text-center text-danger mt-3"><a class="btn" href="../">
                    <i class="fa-solid fa-house"></i><span class="mx-2 fw-bold">Homepage-></span></a>
            </div>
            <div class="text-center text-danger mt-3"><a class="btn" href="../admin">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="mx-2 fw-bold">Are you Admin ? click</span></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function onlyDigits(event) {
            var charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                return false;
            }
            return true;
        }
    </script>
</body>

</html>