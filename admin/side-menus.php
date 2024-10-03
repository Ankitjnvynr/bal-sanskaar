<?php
if (isset($_SESSION['phone'])) {
    header('Location: ../login');
    exit;
}

?>
<?php

?>
<style>
    .dropdown-item:hover{
        background-color:#dc3545;
    }
</style>

<ul class="nav flex-column">
    <div class="logo text-center shadow pt-2 rounded">
        <img width="80px" class='shadow rounded rounded-pill' src="../imgs/logo.png" alt="">
        <p class="text-light mt-2 fw-bolder rounded">GIEO Gita-Bal Sanskaar</p>
    </div>
    <li class="nav-item mt-3">
        <a class="nav-link" href="dashboard.php?data=student"> Students</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="dashboard.php?data=teacher"> Teachers</a>
    </li>
    <li class="nav-item mt-3">
        <a class="nav-link" href="addStudent.php">Add Student</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="addTeacher.php">Add Teacher</a>
    </li>
    <li class="nav-item dropdown">
        <a style="cursor:pointer;" data-bs-toggle="dropdown" class="nav-link dropdown-toggle  text-left ">Report</a>
        <ul  class="dropdown-menu bg-danger">
            <li><a class="dropdown-item" href="report.php">Teachers</a></li>
            <li><a class="dropdown-item" href="reportstudent.php">Student</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="syllabus.php">Syllabus</a>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
    </li>
</ul>