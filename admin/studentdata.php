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
$sql .= " LIMIT $start_from, $limit";
$result = $conn->query($sql);

// Debugging step: Print out the first row to check column names
if ($result->num_rows > 0) {
    $first_row = $result->fetch_assoc();
    // echo '<pre>' . print_r(array_keys($first_row), true) . '</pre>';
    $result->data_seek(0); // Reset pointer to the start of the result set
}
?>

<h4>Students Table</h4>
<form class="d-flex mb-4" method="GET" action="dashboard.php">
    <input type="hidden" name="data" value="student">
    <input class="form-control me-2" type="search" name="search" placeholder="Search"
        value="<?php echo htmlspecialchars($search_query); ?>" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
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

$pagLink = "<nav><ul class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    $pagLink .= "<li class='page-item'><a class='page-link' href='dashboard.php?page=$i";
    if ($search_query !== '') {
        $pagLink .= "&search=$search_query";
    }
    $pagLink .= "'>$i</a></li>";
}
echo $pagLink . "</ul></nav>";

$conn->close();
?>
