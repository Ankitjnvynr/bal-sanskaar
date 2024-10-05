<?php
// Pagination logic
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$start_from = ($page - 1) * $limit;

// Filter and search logic
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$country_filter = isset($_GET['country']) ? $conn->real_escape_string($_GET['country']) : '';
$state_filter = isset($_GET['state']) ? $conn->real_escape_string($_GET['state']) : '';
$district_filter = isset($_GET['district']) ? $conn->real_escape_string($_GET['district']) : '';
$tehsil_filter = isset($_GET['tehsil']) ? $conn->real_escape_string($_GET['tehsil']) : '';
$name_filter = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$phone_filter = isset($_GET['phone']) ? $conn->real_escape_string($_GET['phone']) : '';
$register_option_filter = isset($_GET['register_option']) ? $conn->real_escape_string($_GET['register_option']) : '';

// Construct the SQL query with filters
$sql = "SELECT * FROM students WHERE 1=1";

if ($search_query !== '') {
    $sql .= " AND (name LIKE '%$search_query%' OR father_name LIKE '%$search_query%' OR mother_name LIKE '%$search_query%')";
}
if ($country_filter !== '') {
    $sql .= " AND country = '$country_filter'";
}
if ($state_filter !== '') {
    $sql .= " AND state = '$state_filter'";
}
if ($district_filter !== '') {
    $sql .= " AND district = '$district_filter'";
}
if ($tehsil_filter !== '') {
    $sql .= " AND tehsil = '$tehsil_filter'";
}
if ($name_filter !== '') {
    $sql .= " AND name LIKE '%$name_filter%'";
}
if ($phone_filter !== '') {
    $sql .= " AND (father_phone LIKE '%$phone_filter%' OR mother_phone LIKE '%$phone_filter%')";
}
if ($register_option_filter !== '') {
    $sql .= " AND register_option = '$register_option_filter'";
}

$sql .= " LIMIT $start_from, $limit ";
$result = $conn->query($sql);

// Total record count for pagination
$count_sql = "SELECT COUNT(id) FROM students WHERE 1=1";
if ($search_query !== '') {
    $count_sql .= " AND (name LIKE '%$search_query%' OR father_name LIKE '%$search_query%' OR mother_name LIKE '%$search_query%')";
}
if ($country_filter !== '') {
    $count_sql .= " AND country = '$country_filter'";
}
if ($state_filter !== '') {
    $count_sql .= " AND state = '$state_filter'";
}
if ($district_filter !== '') {
    $count_sql .= " AND district = '$district_filter'";
}
if ($tehsil_filter !== '') {
    $count_sql .= " AND tehsil = '$tehsil_filter'";
}
if ($name_filter !== '') {
    $count_sql .= " AND name LIKE '%$name_filter%'";
}
if ($phone_filter !== '') {
    $count_sql .= " AND (father_phone LIKE '%$phone_filter%' OR mother_phone LIKE '%$phone_filter%')";
}
if ($register_option_filter !== '') {
    $count_sql .= " AND register_option = '$register_option_filter'";
}

$count_result = $conn->query($count_sql);
$row = $count_result->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);
?>

<!-- Filters and Search Form -->
<h5>Students List - (Showing <?php echo $start_from + 1; ?>-<?php echo min($start_from + $limit, $total_records); ?> out of <?php echo $total_records; ?>)</h5>
<form class="d-flex mb-4" method="GET" action="">
    <input type="hidden" name="data" value="student">
    <div class="form-container">
        <div class="form-group">
            <select id="countrySelect" onchange="loadState(this)" name="country">
                <!-- Populate countries here -->
            </select>
        </div>
        <div class="form-group">
            <select id="stateSelect" onchange="loadDistrict(this)" name="state">
                <!-- Populate states here -->
            </select>
        </div>
        <div class="form-group">
            <select id="districtSelect" onchange="loadTehsil(this)" name="district">
                <!-- Populate districts here -->
            </select>
        </div>
        <div class="form-group">
            <select id="tehsil" name="tehsil">
                <!-- Populate tehsils here -->
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="filter-input" id="name" name="name" placeholder="Name" value="<?php echo htmlspecialchars($name_filter); ?>">
        </div>
        <div class="form-group">
            <input type="tel" class="filter-input" id="phone" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($phone_filter); ?>">
        </div>
        <div class="form-group">
            <select name="register_option" id="register_option">
                <option value="">Select Registration Option</option>
                <option value="Yes" <?php echo ($register_option_filter == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo ($register_option_filter == 'No') ? 'selected' : ''; ?>>No</option>
                <option value="FOC" <?php echo ($register_option_filter == 'FOC') ? 'selected' : ''; ?>>FOC</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-success p-0 px-1 flex-1 w-full fltr-btn" type="submit">Search</button>
        </div>
    </div>
</form>

<!-- Results Table -->
<div class="table-responsive">
    <table class="table table-bordered fs-7">
        <thead class="thead-light">
            <tr>
                <th>Sr</th>
                <th>R.No</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Father's Name</th>
                <th>Father's Phone</th>
                <th>Mother's Name</th>
                <th>Mother's Phone</th>
                <th>Country</th>
                <th>State</th>
                <th>District</th>
                <th>Tehsil</th>
                <th>Address</th>
                <th>Center</th>
                <th>Register Option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $sr = $start_from; // Adjust the serial number according to pagination
                while ($row = $result->fetch_assoc()) {
                    $sr++;
                    echo "<tr>
                            <td>{$sr}</td>
                            <td>{$row['rollno']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['dob']}</td>
                            <td>{$row['father_name']}</td>
                            <td>{$row['father_phone']}</td>
                            <td>{$row['mother_name']}</td>
                            <td>{$row['mother_phone']}</td>
                            <td>" . (isset($row['country']) ? htmlspecialchars($row['country']) : 'N/A') . "</td>
                            <td>" . (isset($row['state']) ? htmlspecialchars($row['state']) : 'N/A') . "</td>
                            <td>" . (isset($row['district']) ? htmlspecialchars($row['district']) : 'N/A') . "</td>
                            <td>" . (isset($row['tehsil']) ? htmlspecialchars($row['tehsil']) : 'N/A') . "</td>
                            <td>{$row['address']}</td>
                            <td>" . $row['center'] ? 'BS-' . $row['center'] : '' . "</td>
                            <td>" . (isset($row['register_option']) ? htmlspecialchars($row['register_option']) : 'N/A') . "</td>
                            <td class=''>
                                <div class='d-flex'>
                                    <a href='update_student.php?id={$row['id']}' class='btn btn-sm'><i class='fa-regular fa-pen-to-square text-success fs-5'></i></a>
                                    <a href='delete_student.php?id={$row['id']}' class='btn btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'><i class='fa-regular fa-trash-can text-danger fs-5'></i></a>
                                </div>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='15'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center align-items-center">
    <?php
    // Pagination links
    $pagLink = "<nav><ul class='pagination'>";

    // Define the range of pages to show
    $max_links = 3; // Max number of links to show before and after the current page
    $start = max(1, $page - $max_links); // Ensure the start doesn't go below 1
    $end = min($total_pages, $page + $max_links); // Ensure the end doesn't go above total_pages

    // Previous button
    if ($page > 1) {
        $pagLink .= "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>&laquo;</a></li>";
    }

    // Page number links
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            $pagLink .= "<li class='page-item active'><a class='page-link' href='#'>{$i}</a></li>";
        } else {
            $pagLink .= "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
        }
    }

    // Next button
    if ($page < $total_pages) {
        $pagLink .= "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>&raquo;</a></li>";
    }

    $pagLink .= "</ul></nav>";
    echo $pagLink;
    ?>
</div>
