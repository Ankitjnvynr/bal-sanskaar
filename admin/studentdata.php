<?php
// Pagination logic
$limit = 10; // Number of entries to show in a page.
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$start_from = ($page - 1) * $limit;

// Search logic
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM students";
if ($search_query !== '') {
    $sql .= " WHERE name LIKE '%$search_query%' OR father_name LIKE '%$search_query%' OR mother_name LIKE '%$search_query%'";
}
$sql .= " LIMIT $start_from, $limit ";
$result = $conn->query($sql);

// Debugging step: Print out the first row to check column names
if ($result->num_rows > 0) {
    $first_row = $result->fetch_assoc();
    // echo '<pre>' . print_r(array_keys($first_row), true) . '</pre>';
    $result->data_seek(0); // Reset pointer to the start of the result set
}
?>

<h4>Students List-(2400/4000)</h4>
<form class="d-flex mb-4" method="GET" action="">
    <div class="form-container">
        
            <div class="form-group">
                
                <select id="country" name="country" >
                    <option value="India">India</option>
                    <option value="USA">USA</option>
                    <option value="Canada">Canada</option>
                </select>
            </div>
            <div class="form-group">
                
                <select id="state" name="state">
                    <option value="State1">Haryana</option>
                    <option value="State2">Chandigarh</option>
                </select>
            </div>
            <div class="form-group">
                
                <select id="district" name="district">
                    <option value="District1">Kurukshetra</option>
                    <option value="District2">pehowa</option>
                    <option value="District2">Karnal</option>
                </select>
            </div>
            <div class="form-group">
                
                <select id="tehsil" name="tehsil">
                    <option value="Tehsil1">Thanesar</option>
                    <option value="Tehsil2">karnal</option>
                </select>
            </div>
            <div class="form-group">
                
                <input type="text"  class="filter-input" id="name" name="name" placeholder=" Name">
            </div>
            <div class="form-group">
                
                <input type="tel"  class="filter-input" id="phone" name="phone" placeholder=" Phone Number">
            </div>
           
    
            <div class="form-group">
            <input type="hidden" name="data" value="Student">
        <!-- <input class="form-control me-2" type="search" name="search" placeholder="Search..." aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>"> -->
        <button class="btn btn-outline-success p-0 px-1 flex-1 w-full  fltr-btn" type="submit" >Search</button>
     
        
            </div>
<!-- <form class="d-flex mb-4" method="GET" action="dashboard.php">
    <input type="hidden" name="data" value="student">
    <input class="form-control me-2" type="search" name="search" placeholder="Search"
        value="<?php echo htmlspecialchars($search_query); ?>" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button> -->
</form>
<div class="table-responsive">
    <table class="table table-bordered fs-7">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
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
                $sr = 0;
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
                            <div  class='d-flex'>
                            <a href='update_student.php?id={$row['id']}' class='btn btn-sm '><i class='fa-regular fa-pen-to-square text-success fs-5'></i> </a>
                                <a href='delete_student.php?id={$row['id']}' class='btn btn-sm ' onclick='return confirm(\"Are you sure you want to delete this record?\");'><i class='fa-regular fa-trash-can text-danger fs-5'></i> </a>
                            
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

<div class="d-flex justify-content-center align-items-center">
<?php

// Pagination for search results
$count_sql = "SELECT COUNT(id) FROM students";
if ($search_query !== '') {
    $count_sql .= " WHERE name LIKE '%$search_query%' OR father_name LIKE '%$search_query%' OR mother_name LIKE '%$search_query%'";
}
$count_result = $conn->query($count_sql);
$row = $count_result->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);

$range = 2; // Number of page links to show on either side of the current page
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);

$pagLink = "<nav><ul class='pagination'>";

// Previous button
if ($page > 1) {
    $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=" . ($page - 1);
    if ($search_query !== '') {
        $pagLink .= "&search=$search_query";
    }
    $pagLink .= "'>&laquo;</a></li>";
}

// First page
if ($start_page > 1) {
    $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?data=student&page=1";
    if ($search_query !== '') {
        $pagLink .= "&search=$search_query";
    }
    $pagLink .= "'>1</a></li>";
    if ($start_page > 2) {
        $pagLink .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
    }
}

// Page links
for ($i = $start_page; $i <= $end_page; $i++) {
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

// Last page
if ($end_page < $total_pages) {
    if ($end_page < $total_pages - 1) {
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

$conn->close();


?>
</div>