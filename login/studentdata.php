<?php

include '../config/_db.php'; // include the database connection

// Variables for search and pagination
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$recordsPerPage = 10;
$offset = ($page - 1) * $recordsPerPage;

// Get total records for pagination calculation
$sqlTotal = "SELECT COUNT(*) AS total FROM students WHERE `state` = '{$_SESSION['state']}'";
if ($_SESSION['userType'] == 'City Head')
{
  $sqlTotal .= " AND `district` = '{$_SESSION['district']}' AND `tehsil` = '{$_SESSION['tehsil']}'";
}
if ($_SESSION['userType'] == 'Teacher')
{
  $sqlTotal .= " AND `center` = '{$_SESSION['userCenter']}'";
}
if ($search)
{
  $sqlTotal .= " AND (name LIKE '%$search%' OR father_name LIKE '%$search%' OR mother_name LIKE '%$search%')";
}

// Debugging: Print the SQL query
// echo $sqlTotal;

$resultTotal = $conn->query($sqlTotal);
if (!$resultTotal)
{
  die("Error in SQL query: " . $conn->error);
}

$totalRecords = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch filtered and paginated data
$sql = "SELECT * FROM students WHERE `state` = '{$_SESSION['state']}'";
if ($_SESSION['userType'] == 'City Head') 
{
  $sql .= " AND `district` = '{$_SESSION['district']}' AND `tehsil` = '{$_SESSION['tehsil']}'";
}
if ($_SESSION['userType'] == 'Teacher')
{
  $sql .= " AND `district` = '{$_SESSION['district']}' AND `tehsil` = '{$_SESSION['tehsil']}' AND `center` = '{$_SESSION['userCenter']}'";
}
if ($search)
{
  $sql .= " AND (name LIKE '%$search%' OR father_name LIKE '%$search%' OR mother_name LIKE '%$search%')";
}
$sql .= " LIMIT $offset, $recordsPerPage";

// Debugging: Print the SQL query
// echo $sql;

$result = $conn->query($sql);
if (!$result)
{
  die("Error in SQL query: " . $conn->error);
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
  <div
    class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
    <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none"></i>
    Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
  </div>
  <div class="text-danger h5">Students Data</div>

  <!-- Search Form -->
  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="hidden" name="data" value="student">
      <input type="text" name="search" class="form-control" placeholder="Search..."
        value="<?php echo htmlspecialchars($search); ?>">
      <button class="btn btn-primary" type="submit">Search</button>
    </div>
  </form>

  <div class="table-responsive">
    <table id="" class="table fs-7 table-striped">
      <thead>
        <tr>
          <th scope="col">Sr</th>
          <th scope="col">R.No</th>
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
          <th scope="col">Address</th>
          <th scope="col">Center</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0)
        {
          $sr = $offset + 1;
          while ($row = $result->fetch_assoc())
          {
            echo "<tr>
                    <th scope='row'>{$sr}</th>
                    <td>{$row['rollno']}</td>
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
                    <td>{$row['address']}</td>
                    <td>{$row['center']}</td>
                    <td class='d-flex gap-1 h-100'>
                      <a data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Tooltip on top' href='edit_student.php?id={$row['id']}' class='btn btn-sm btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                      <a href='delete_student.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'><i class='fa-solid fa-trash'></i></a>
                    </td>
                  </tr>";
            $sr++;
          }
        } else
        {
          echo "<tr><td colspan='15' class='text-center'>No records found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
        <li class="page-item"><a class="page-link"
            href="?data=student&page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a></li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link"
            href="?data=student&page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a></li>
      <?php endfor; ?>
      <?php if ($page < $totalPages): ?>
        <li class="page-item"><a class="page-link"
            href="?data=student&page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</main>