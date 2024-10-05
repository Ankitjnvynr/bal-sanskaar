<?php
if ($_SESSION['userType'] == 'admin' || !isset($_SESSION['phone']))
{
    header('Location: ../admin/');
    exit;
}

$userName = $_SESSION['username'];
$userPhone = $_SESSION['phone'];
$userDistrict = $_SESSION['district'];
$userTehsil = $_SESSION['tehsil'];
$userType = $_SESSION['userType'];

?>


<ul style="height:98vh;" class="nav flex-column fs-7">
    <div class="logo text-center shadow  rounded">
        <img width="50px" class='shadow rounded rounded-pill' src="../imgs/logo.png" alt="">
        <p class="text-light mt-2 fw-bolder rounded">GIEO Gita-Bal Sanskaar</p>
    </div>
    

    <li class="nav-item mt-3">
        <a class="nav-link" href="dashboard.php?data=student">All Student</a>
    </li>
    <li class="nav-item border-top">
        <a class="nav-link" href="addStudent.php">Add Student</a>
    </li>
    <?php
    if ($userType == 'City Head' || $userType == 'State Head')
    {
        ?>
    <li class="nav-item border-top">
        <a class="nav-link" href="dashboard.php?data=teacher">All Teacher</a>
    </li>
    <li class="nav-item border-top">
        <a class="nav-link" href="addTeacher.php">Add Teachers</a>
    </li>
    <li  class="d-flex flex-column position-relative">
        <div id="searchBar">
            <input type="text" class="form-control" id="searchInput" placeholder="Search... by name">
        </div>
        <ul id="itemList" style="height:36vh;" class="list-group bg-warning-subtle fs-7 overflow-y-scroll">
            <?php
                    $currentUserId = $_SESSION['id'];
                    $sql = "SELECT * FROM teachers WHERE id != $currentUserId AND `state` = '{$_SESSION['state']}'";

                    if ($userType == 'City Head')
                    {
                        $sql .= " AND `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
                    }
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0)
                    {
                        while ($row = $result->fetch_assoc())
                        {
                            $name = mb_convert_case($row['name'], MB_CASE_TITLE, "UTF-8");
                            $center = mb_convert_case($row['center'], MB_CASE_TITLE, "UTF-8");
                            echo "<li class='list-group-item bg-warning-subtle'><a class='text-black fs-7 m-0 p-0' href='?data=filterStudent&center={$row['center']}'>{$name}<span style='font-size:0.8rem;' class='fw-semibold fs-7 text-muted'>({$center})</span></a></li>";
                        }
                    }
                    ?>
        </ul>
    </li>
    <?php
    }
    ?>
    <li class="nav-item border-top">
        <a class="nav-link" href="profile.php">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="syllabus.php">Syllabus</a>
    </li>
    <li class="nav-item border-top">
        <a class="nav-link" href="logout.php">Logout</a>
    </li>
</ul>