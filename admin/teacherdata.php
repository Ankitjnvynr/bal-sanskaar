<?php

// Set the number of records to display per page
$records_per_page = 10;

// Get the current page or set default to 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $records_per_page;

// Get the search query if any
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query to fetch data with pagination and search
$sql = "SELECT * FROM teachers 
        WHERE name LIKE ? 
        OR phone LIKE ? 
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);
if ($stmt === false)
{
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$search_term = "%" . $search_query . "%";
$stmt->bind_param("ssii", $search_term, $search_term, $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();

// SQL query to get the total number of records for pagination
$total_records_sql = "SELECT COUNT(*) AS total FROM teachers WHERE name LIKE ? OR phone LIKE ?";
$total_stmt = $conn->prepare($total_records_sql);
if ($total_stmt === false)
{
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$total_stmt->bind_param("ss", $search_term, $search_term);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_records = $total_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);
?>

<div class="">
    <h4 class="mb-4">Teachers List</h4>

    <!-- Search Form -->
    <form class="d-flex mb-4" method="GET" action="">
        <input type="hidden" name="data" value="teacher">
        <input class="form-control me-2" type="search" name="search" placeholder="Search..." aria-label="Search"
            value="<?php echo htmlspecialchars($search_query); ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-striped fs-7">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Teacher Type</th>
                    <th scope="col">Name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Qualification</th>
                    <th scope="col">Country</th>
                    <th scope="col">State</th>
                    <th scope="col">District</th>
                    <th scope="col">Tehsil</th>
                    <th scope="col">Center</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0)
                {
                    $sr = 0;
                    while ($row = $result->fetch_assoc()):
                        $sr++; ?>
                        <tr>
                            <th scope="row"><?php echo $sr; ?></th>
                            <td>
                                <select class="border" onchange="changeTeacherType(<?php echo $row['id']; ?>,this)">
                                    <?php
                                    $arr = ['Teacher', 'Head Teacher','State Head'];
                                    foreach ($arr as $value)
                                    {
                                        if ($row['teacher_type'] == $value)
                                        {
                                            echo '<option selected value="' . $value . '">' . $value . '</option>';
                                        } else
                                        {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['qualification']; ?></td>
                            <td><?php echo $row['country']; ?></td>
                            <td><?php echo $row['state']; ?></td>
                            <td><?php echo $row['district']; ?></td>
                            <td><?php echo $row['tehsil']; ?></td>
                            <td><?php echo $row['center']; ?></td>
                            <td>
                                <a href="updateTeacher.php?user=<?php echo $row['id']; ?>" class="btn p-0 m-0 mx-1 fs-5"><i
                                        class="fa-regular fa-pen-to-square text-success"></i></a>
                                <a href="delete_teacher.php?id=<?php echo $row['id'] . '&page=' . $page; ?>" onclick='return confirm("Are you sure you want to delete this record?")'
                                    class="btn p-0 m-0 mx-1 fs-5"><i class="fa-regular fa-trash-can text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endwhile;
                } else
                {
                    echo "<tr><td colspan='12'>No records found</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search_query); ?>"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page)
                    echo 'active'; ?>">
                    <a class="page-link"
                        href="?data=teacher&page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search_query); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?data=teacher&page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search_query); ?>"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>

                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>