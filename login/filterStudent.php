<?php

$userName = $_SESSION['username'];
$userPhone = $_SESSION['phone'];
$userDistrict = $_SESSION['district'];
$userTehsil = $_SESSION['tehsil'];
$userType = $_SESSION['userType'];

if ($userType == 'Teacher') {
    header('location:?data=student');
    exit();
}

// Pagination and search logic
$items_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$offset = ($page - 1) * $items_per_page;

include '../config/_db.php'; // include the database connection

$sql = "SELECT COUNT(*) AS total FROM students WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
if ($search) {
    $sql .= " AND (`name` LIKE '%$search%' OR `father_name` LIKE '%$search%' OR `mother_name` LIKE '%$search%')";
}
$result = $conn->query($sql);
$total_items = $result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

$sql = "SELECT * FROM students WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
if ($search) {
    $sql .= " AND (`name` LIKE '%$search%' OR `father_name` LIKE '%$search%' OR `mother_name` LIKE '%$search%')";
}
$sql .= " LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE); ?>
    </div>
    <div class="text-danger h5">Students Data</div>
    <div class="overflow-x-scroll">
        <input type="text" id="search" class="form-control mb-3" placeholder="Search...">
        <table id="myTable" class="table fs-7 table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Father's Name</th>
                    <th scope="col">Father's Phone</th>
                    <th scope="col">Mother's Name</th>
                    <th scope="col">Mother's Phone</th>
                    <th scope="col">Country</th>
                    <th scope="col">State</th>
                    <th scope="col">District</th>
                    <th scope="col">Tehsil</th>
                    <th scope="col">Center</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($total_items > 0) {
                    $sr = $offset;
                    while ($row = $result->fetch_assoc()) {
                        $sr++;
                        echo "<tr>
                                  <th scope='row'>{$sr}</th>
                                  <td>{$row['name']}</td>
                                  <td>{$row['dob']}</td>
                                  <td>{$row['father_name']}</td>
                                  <td>{$row['father_phone']}</td>
                                  <td>{$row['mother_name']}</td>
                                  <td>{$row['mother_phone']}</td>
                                  <td>{$row['country']}</td>
                                  <td>{$row['state']}</td>
                                  <td>{$row['district']}</td>
                                  <td>{$row['tehsil']}</td>
                                  <td>{$row['center']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <span>Total Items: <?php echo $total_items; ?></span>
            <nav>
                <ul class="pagination">
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = $i == $page ? 'active' : '';
                        echo "<li class='page-item $active'><a class='page-link' href='?page=$i&search=$search'>$i</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<script>
    document.getElementById('search').addEventListener('input', function() {
        const search = this.value;
        window.location.href = '?search=' + search;
    });
</script>

</body>
</html>
<?php
$conn->close();
?>
