<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}

include '../config/_db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GIEO Gita-Bal Sanskaar Yojna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/admin-filter-input.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <style>
        .form-item {
            flex: 1 0 230px;
        }

        .fs-7 {
            font-size: 0.9rem;
        }
    </style>
    <style>
        .sidebar {
            min-height: 100vh;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: all 0.5s;
        }

        .sidebar a:hover {
            color: white;
            /* background-color: #741414; */
            transform: translatex(5px)
        }
    </style>
    <style>

.form-container {
    display:flex;
    flex-wrap:wrap;
    border-radius: 8px;
    width: 100%;
    gap:3px;
}

select, .filter-input {

    width: 100%;
    padding: 0 10px;
    border: 1px solid #ccc;
    border-radius: 4px;

}
 .form-group{
    min-width:100px;
    display:flex;
    flex:1;
 }
.submit-btn {
   width:100%;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 10px;
    margin-left
}
    .submit-btn:hover {
    background-color: #0056b3;
} 
.fltr-btn{
    width:100%;
    max-width:3000px;
}
/* filter-btn */
.filter-btn-rld{
border: 1px solid red;
border-radius:5px;
font-size:15px;
font-weight:2px;
color:red;
margin-bottom:10px;

}

    </style>
    <script>
        updating = false;
    </script>
</head>

<body class="bg-warning-subtle">

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-none d-md-block   bg-danger sidebar">
                <div class="position-sticky">
                    <?php
                    include 'side-menus.php'
                    ?>
                </div>
            </nav>

            <div style="max-width:70%" class="offcanvas offcanvas-start bg-danger" tabindex="-1" id="sidebarCanvas" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body sidebar">
                    <?php
                    include 'side-menus.php'
                    ?>
                </div>
            </div>