<?php
require_once '../config/_db.php';

session_start();
if (isset($_SESSION['loggedin']))
{
    //	header('location : dashboard.php');
    header('location:dashboard.php?data=student');

    exit;
}
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username']) || $_POST['username'] == "") {
        $msg = "Please enter username";
    } else {
        $username = $_POST['username'];
        $checkuser = "SELECT * FROM teachers WHERE `phone` = '$username'";
        $result = $conn->query($checkuser);
        if ($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    
                    echo $_SESSION['loggedin'] = true;
                    echo $_SESSION['username'] = $row['name'];
                    echo $_SESSION['phone']= $row['phone'];
                    echo $_SESSION['district']= $row['district'];
                    echo $_SESSION['tehsil']= $row['tehsil'];
                    echo $_SESSION['userType'] = $row['teacher_type'];
                    $msg = "Teacher exists!";

                    header('location:dashboard.php?data=student');
                    exit;
                }
                // Further processing or redirect as needed
            } else {
                // No teacher found with the given phone number
                $msg = "Phone no not exist";
                // Handle accordingly, such as displaying an error message or redirecting
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GIEO Gita-Bal Sanskaar Yojna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
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

    <div class="container h-full d-flex align-items-center justify-content-center">
        <!-- Login Form -->
        <div id="loginForm" class="card p-4 shadow-sm col-md-4">
            <div class="text-center fw-bold my-2 text-danger fs-3">Login</div>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter phone no as username" />
                </div>
                <!-- <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div> -->
                <!-- <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="teacher">Teacher</option>
                        <option value="headmaster">Headmaster</option>
                    </select>
                </div> -->
                <div class="text-center">
                    <button type="submit" class="btn btn-danger">Login</button>
                </div>
                <div class="email-help text-danger text-center"><?php
                                                                echo $msg;
                                                                ?></div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>