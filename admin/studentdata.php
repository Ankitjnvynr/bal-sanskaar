<?php
// Pagination logic
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$start_from = ($page - 1) * $limit;

// Filter and search logic
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$country_filter = isset($_GET['country']) ? $conn->real_escape_string($_GET['country']) : '';
$state_filter = isset($_GET['state']) ? $conn->real_escape_string($_GET['state']) : '';
$district_filter = isset($_GET['district']) ? $conn->real_escape_string($_GET['district']) : '';
$tehsil_filter = isset($_GET['tehsil']) ? $conn->real_escape_string($_GET['tehsil']) : '';
$name_filter = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$phone_filter = isset($_GET['phone']) ? $conn->real_escape_string($_GET['phone']) : '';

// Construct the SQL query with filters
$sql = "SELECT * FROM students WHERE 1 = 1";

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

$sql .= " LIMIT $start_from, $limit ";
$result = $conn->query($sql);

// Total record count for pagination
$count_sql = "SELECT COUNT(id) FROM students WHERE 1 = 1";
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

$count_result = $conn->query($count_sql);
$row = $count_result->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);
?>

<!-- Filters and Search Form -->
<h5>Students List - (Showing <?php echo $start_from + 1; ?>-<?php echo min($start_from + $limit, $total_records); ?> out of <?php echo $total_records; ?>)</h5>
<form class="d-flex mb-4" method="GET" action="">
    <div class="form-container">
        <div class="form-group">
            <select id="country" name="country">
                <option value="">All Countries</option>
                <option value="India" <?php if ($country_filter == 'India') echo 'selected'; ?>>India</option>
                <option value="USA" <?php if ($country_filter == 'USA') echo 'selected'; ?>>USA</option>
                <option value="Canada" <?php if ($country_filter == 'Canada') echo 'selected'; ?>>Canada</option>
            </select>
        </div>
        <div class="form-group">
            <select id="state" name="state">
                <option value="">All States</option>
                <option value="Haryana" <?php if ($state_filter == 'Haryana') echo 'selected'; ?>>Haryana</option>
                <option value="Chandigarh" <?php if ($state_filter == 'Chandigarh') echo 'selected'; ?>>Chandigarh</option>
            </select>
        </div>
        <div class="form-group">
            <select id="district" name="district">
                <option value="">All Districts</option>
                <option value="Kurukshetra" <?php if ($district_filter == 'Kurukshetra') echo 'selected'; ?>>Kurukshetra</option>
                <option value="Pehowa" <?php if ($district_filter == 'Pehowa') echo 'selected'; ?>>Pehowa</option>
                <option value="Karnal" <?php if ($district_filter == 'Karnal') echo 'selected'; ?>>Karnal</option>
            </select>
        </div>
        <div class="form-group">
            <select id="tehsil" name="tehsil">
                <option value="">All Tehsils</option>
                <option value="Thanesar" <?php if ($tehsil_filter == 'Thanesar') echo 'selected'; ?>>Thanesar</option>
                <option value="Karnal" <?php if ($tehsil_filter == 'Karnal') echo 'selected'; ?>>Karnal</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="filter-input" id="name" name="name" placeholder="Name" value="<?php echo htmlspecialchars($name_filter); ?>">
        </div>
        <div class="form-group">
            <input type="tel" class="filter-input" id="phone" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($phone_filter); ?>">
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
                <th>Father's DOB</th>
                <th>Mother's Name</th>
                <th>Mother's Phone</th>
                <th>Mother's DOB</th>
                <th>Country</th>
                <th>State</th>
                <th>District</th>
                <th>Tehsil</th>
                <th>Address</th>
                <th>Center</th>
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
                            <td>{$row['father_dob']}</td>
                            <td>{$row['mother_name']}</td>
                            <td>{$row['mother_phone']}</td>
                            <td>{$row['mother_dob']}</td>
                            <td>" . (isset($row['country']) ? $row['country'] : 'N/A') . "</td>
                            <td>" . (isset($row['state']) ? $row['state'] : 'N/A') . "</td>
                            <td>" . (isset($row['district']) ? $row['district'] : 'N/A') . "</td>
                            <td>" . (isset($row['tehsil']) ? $row['tehsil'] : 'N/A') . "</td>
                            <td>{$row['address']}</td>
                            <td>{$row['center']}</td>
                            <td class=''>
                                <div class='d-flex'>
                                    <a href='update_student.php?id={$row['id']}' class='btn btn-sm'><i class='fa-regular fa-pen-to-square text-success fs-5'></i></a>
                                    <a href='delete_student.php?id={$row['id']}' class='btn btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'><i class='fa-regular fa-trash-can text-danger fs-5'></i></a>
                                </div>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='17'>No records found</td></tr>";
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
        $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=" . ($page - 1);
        if ($search_query !== '') {
            $pagLink .= "&search=$search_query";
        }
        $pagLink .= "'>&laquo;</a></li>";
    }

    // Show the first page link and ellipsis if the start is greater than 1
    if ($start > 1) {
        $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=1";
        if ($search_query !== '') {
            $pagLink .= "&search=$search_query";
        }
        $pagLink .= "'>1</a></li>";

        if ($start > 2) {
            $pagLink .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }
    }

    // Display links within the range
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            $pagLink .= "<li class='page-item active'><span class='page-link'>$i</span></li>";
        } else {
            $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=$i";
            if ($search_query !== '') {
                $pagLink .= "&search=$search_query";
            }
            $pagLink .= "'>$i</a></li>";
        }
    }

    // Show ellipsis and the last page link if the end is less than total_pages
    if ($end < $total_pages) {
        if ($end < $total_pages - 1) {
            $pagLink .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }

        $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=$total_pages";
        if ($search_query !== '') {
            $pagLink .= "&search=$search_query";
        }
        $pagLink .= "'>$total_pages</a></li>";
    }

    // Next button
    if ($page < $total_pages) {
        $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=" . ($page + 1);
        if ($search_query !== '') {
            $pagLink .= "&search=$search_query";
        }
        $pagLink .= "'>&raquo;</a></li>";
    }

    $pagLink .= "</ul></nav>";
    echo $pagLink;
    ?>
</div>

<?php $conn->close(); ?>
