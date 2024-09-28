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

    // Use a prepared statement
    $stmt = $conn->prepare("SELECT * FROM admin_user WHERE username = ?");
    
    // Check if prepare() failed
    if (!$stmt) {
        die("Database prepare error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $num = $result->num_rows;

        if ($num == 1) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['intro'] = true;
                    $_SESSION['userType'] = 'admin';
                    $_SESSION['isAdmin'] = true;
                    header("location: dashboard.php?data=student");
                    exit;
                } else {
                    $msg = "Password does not match";
                }
            }
        } else {
            $msg = "Wrong username";
        }
    } else {
        // Log the error or display a user-friendly message
        $msg = "Database execution error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Your existing HTML head content -->
</head>
<body>
    <!-- Your existing HTML body content -->

    <?php
    if ($msg) {
        echo '
        <div style="top:2%;" class="container position-absolute ">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Alert!</strong> ' . htmlspecialchars($msg) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        ';
    }
    ?>
    
    <!-- Your existing form and footer -->
</body>
</html>
