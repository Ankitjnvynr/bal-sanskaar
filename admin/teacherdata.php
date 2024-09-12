<?php
// Set the number of records to display per page
$records_per_page = 10;

// Get the current page or set default to 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $records_per_page;

// Get filter values from the GET parameters
$country = isset($_GET['country']) ? $_GET['country'] : '';
$state = isset($_GET['state']) ? $_GET['state'] : '';
$district = isset($_GET['district']) ? $_GET['district'] : '';
$tehsil = isset($_GET['tehsil']) ? $_GET['tehsil'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Start building the SQL query with a WHERE clause
$sql = "SELECT * FROM teachers WHERE 1=1";

// Array to hold the conditions and parameters
$params = [];
$types = ''; // Types for bind_param

// Apply filters based on available GET parameters
if (!empty($country)) {
    $sql .= " AND country = ?";
    $params[] = $country;
    $types .= 's'; // string type
}

if (!empty($state)) {
    $sql .= " AND state = ?";
    $params[] = $state;
    $types .= 's';
}

if (!empty($district)) {
    $sql .= " AND district = ?";
    $params[] = $district;
    $types .= 's';
}

if (!empty($tehsil)) {
    $sql .= " AND tehsil = ?";
    $params[] = $tehsil;
    $types .= 's';
}

if (!empty($name)) {
    $sql .= " AND name LIKE ?";
    $params[] = "%" . $name . "%";
    $types .= 's';
}

if (!empty($phone)) {
    $sql .= " AND phone LIKE ?";
    $params[] = "%" . $phone . "%";
    $types .= 's';
}
if (!empty($type)) {
    $sql .= " AND teacher_type LIKE ?";
    $params[] = "%" . $type . "%";
    $types .= 's';
}

// Add the LIMIT for pagination
$sql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $records_per_page;
$types .= 'ii'; // two integer types for offset and limit

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Bind the parameters dynamically
$stmt->bind_param($types, ...$params);
$stmt->execute();

 $result = $stmt->get_result();




?>
<?php
// Create the base URL for pagination with filter values
$base_url = "?data=teacher&country=" . urlencode($country) .
    "&state=" . urlencode($state) .
    "&district=" . urlencode($district) .
    "&tehsil=" . urlencode($tehsil) .
    "&name=" . urlencode($name) .
    "&phone=" . urlencode($phone) . "&page=";
?>
<?php
// SQL query to get the total number of records for pagination (without LIMIT)
$total_records_sql = "SELECT COUNT(*) AS total FROM teachers WHERE 1=1";

// Array to hold the conditions and parameters for the total count query
$total_params = [];
$total_types = ''; // Types for bind_param

// Apply filters based on available GET parameters (same as main query)
if (!empty($country)) {
    $total_records_sql .= " AND country = ?";
    $total_params[] = $country;
    $total_types .= 's'; // string type
}

if (!empty($state)) {
    $total_records_sql .= " AND state = ?";
    $total_params[] = $state;
    $total_types .= 's';
}

if (!empty($district)) {
    $total_records_sql .= " AND district = ?";
    $total_params[] = $district;
    $total_types .= 's';
}

if (!empty($tehsil)) {
    $total_records_sql .= " AND tehsil = ?";
    $total_params[] = $tehsil;
    $total_types .= 's';
}

if (!empty($name)) {
    $total_records_sql .= " AND name LIKE ?";
    $total_params[] = "%" . $name . "%";
    $total_types .= 's';
}

if (!empty($phone)) {
    $total_records_sql .= " AND phone LIKE ?";
    $total_params[] = "%" . $phone . "%";
    $total_types .= 's';
}
if (!empty($type)) {
    $sql .= " AND teacher_type LIKE ?";
    $params[] = "%" . $type . "%";
    $types .= 's';
}

// Prepare the total records SQL statement
$total_stmt = $conn->prepare($total_records_sql);
if ($total_stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Dynamically bind the parameters
if (!empty($total_types)) {
    $total_stmt->bind_param($total_types, ...$total_params);
}

// Execute the total count query
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_records = $total_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

?>

<?php
// Count the number of records for the current page
$current_page_records = $result->num_rows;


?>

<style>
.nametd {
    font-weight: 700;
    cursor: pointer;

}

.nametd:hover {
    text-decoration: underline;
    /* color: red; */
}
</style>

<!-- modal for the teacher profile -->
<!-- Modal -->
<div class="modal fade" id="teacherProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 id="ModalTitle" class="modal-title fs-5" id="staticBackdropLabel">Teacher Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modalBody" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end  modal for the teacher profile -->



<div class="">
    <h5 class="mb-4 teacher-l">
        Teachers List - (<?php echo $current_page_records; ?>/<?php echo $total_records; ?>)
    </h5>
    <!-- Search Form -->
    <form class="d-flex mb-4" method="GET" action="">
        <div class="form-container">
            <div class="form-group">
                <select id="countrySelect" onchange="loadState(this)" name="country"></select>
            </div>
            <div class="form-group">
                <select id="stateSelect" onchange="loadDistrict(this)" name="state"></select>
            </div>
            <div class="form-group">
                <select id="districtSelect" onchange="loadTehsil (this)" name="district"></select>
            </div>
            <div class="form-group">
                <select id="tehsil" name="tehsil"></select>
            </div>
            <div class="form-group">
                <input type="text" class="filter-input" id="name" name="name" placeholder=" Name">
            </div>
            <div class="form-group">
                <input type="tel" class="filter-input" id="phone" name="phone" placeholder=" Phone Number">
            </div>
            <div class="form-group">
                <select name="type" id="type">
                    <option value="">select type</option>
                    <?php 
                        $arr = ['City Head','State Head', 'Teacher','Teacher1'];
                        foreach ($arr as $item) {
                            echo '<option value="'.$item.'">'.$item.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="data" value="teacher">
                <!-- <input class="form-control me-2" type="search" name="search" placeholder="Search..." aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>"> -->
                <button class="btn btn-outline-success p-0 px-1 flex-1 w-full  fltr-btn" type="submit">Search</button>
            </div>
        </div>
</div>
</form>

<!-- Data Table -->
<div class="table-responsive">
    <table class="table table-striped fs-7">
        <thead>
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Teacher Type</th>
                <th scope="col">Name</th>
                <th scope="col">DOB</th>
                <th scope="col">Phone</th>
                <th scope="col">Qualification</th>
                <th scope="col">Country</th>
                <th scope="col">State</th>
                <th scope="col">District</th>
                <th scope="col">Tehsil</th>
                <th scope="col">Address</th>
                <th scope="col">Center</th>
                <th scope="col">Start On</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    if(isset($_GET['page'])){
                        $sr = 10*($_GET['page']-1);
                    }else{
                        $sr = 0;
                    }
                    while ($row = $result->fetch_assoc()) :
                        $sr++; ?>
            <tr>
                <th scope="row"><?php echo $sr; ?></th>
                <td>
                    <?php echo $row['teacher_type'] ?>
                </td>
                <td class="nametd" data-bs-toggle="modal"
                    onclick="openTeacherProfileModal(this,<?php echo $row['id']; ?>)">
                    <?php echo $row['name']; ?></td>
                <td><?php echo $row['dob']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['qualification']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td><?php echo $row['state']; ?></td>
                <td><?php echo $row['district']; ?></td>
                <td><?php echo $row['tehsil']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['center']; ?></td>
                <td><?php echo substr($row['dt'], 0, 10); ?></td>
                <td>
                    <a href="updateTeacher.php?user=<?php echo $row['id']; ?>" class="btn p-0 m-0 mx-1 fs-5"><i
                            class="fa-regular fa-pen-to-square text-success"></i></a>
                    <a href="delete_teacher.php?id=<?php echo $row['id'] . '&page=' . $page; ?>"
                        onclick='return confirm("Are you sure you want to delete this record?")'
                        class="btn p-0 m-0 mx-1 fs-5"><i class="fa-regular fa-trash-can text-danger"></i></a>
                </td>
            </tr>
            <?php endwhile;
                } else {
                    echo "<tr><td colspan='12'>No records found</td></tr>";
                } ?>
        </tbody>
    </table>
</div>


<!-- Pagination -->
<?php
// Create the base URL for pagination with filter values
$base_url = "?data=teacher&country=" . urlencode($country) .
    "&state=" . urlencode($state) .
    "&district=" . urlencode($district) .
    "&tehsil=" . urlencode($tehsil) .
    "&name=" . urlencode($name) .
    "&phone=" . urlencode($phone) .
    "&type=" . urlencode($type) .  // Added type filter
    "&page=";
?>

<?php if ($total_pages > 1): // Only show pagination if there's more than one page ?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- Previous Button -->
        <?php if ($page > 1) : ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $base_url . ($page - 1); ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Page Number Buttons -->
        <?php
        $visible_buttons = 3; 
        $start_page = max(1, $page - floor($visible_buttons / 2));
        $end_page = min($total_pages, $page + floor($visible_buttons / 2));

        if ($end_page - $start_page + 1 < $visible_buttons) {
            if ($start_page == 1) {
                $end_page = min($total_pages, $start_page + $visible_buttons - 1);
            } else {
                $start_page = max(1, $end_page - $visible_buttons + 1);
            }
        }

        if ($start_page > 1) : ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $base_url . '1'; ?>">1</a>
        </li>
        <?php if ($start_page > 2) : ?>
        <li class="page-item disabled">
            <span class="page-link">...</span>
        </li>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Display page number buttons -->
        <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="<?php echo $base_url . $i; ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>

        <?php if ($end_page < $total_pages) : ?>
        <?php if ($end_page < $total_pages - 1) : ?>
        <li class="page-item disabled">
            <span class="page-link">...</span>
        </li>
        <?php endif; ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $base_url . $total_pages; ?>"><?php echo $total_pages; ?></a>
        </li>
        <?php endif; ?>

        <!-- Next Button -->
        <?php if ($page < $total_pages) : ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $base_url . ($page + 1); ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; // End of pagination check ?>



</div>

<script>
function openTeacherProfileModal(e, userId) {
    name = e.innerHTML;
    userId = userId;

    $.ajax({
        type: "POST",
        url: "teacherProfile.php",
        data: {
            teacher_id: userId
        },

        success: function(response) {
            $('#modalBody').html(response)
        }
    });



    $('#teacherProfileModal').modal('show');




    showTeacherList = () => {

        $("#teacher-list").removeAttr("hidden");
        $("#teacher-list").show(5);
        $("#student-list").hide(5);
    }
    showStudentList = () => {
        $("#teacher-list").hide(5);
        $("#student-list").show(5);
    }
};
</script>