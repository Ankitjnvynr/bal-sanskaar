<?php


$userName = $_SESSION['username'];
$userPhone = $_SESSION['phone'];
$userDistrict = $_SESSION['district'];
$userTehsil = $_SESSION['tehsil'];
$userType = $_SESSION['userType'];

if ($userType == 'Teacher')
{
  header('location:?data=student');
  exit();
}

include '../config/_db.php'; // include the database connection

$limit = 10; // Number of entries to show in a page.
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$start_from = ($page - 1) * $limit;

// Initialize search variables
$searchQuery = '';
$search = '';

if (isset($_GET['search']))
{
  $search = $_GET['search'];
  $searchQuery = " AND (name LIKE '%$search%' OR phone LIKE '%$search%' OR center LIKE '%$search%')";
}

// Fetch total records for pagination
$total_records_query = "SELECT COUNT(*) FROM teachers WHERE  district = '$userDistrict' AND tehsil = '$userTehsil' $searchQuery";
if (isset($_GET['center']))
{
  $ctr = $_GET['center'];
  $total_records_query .= " AND center = '$ctr'";
}
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_row()[0];
$total_pages = ceil($total_records / $limit);

// Fetch records for the current page
$currentUserId = $_SESSION['id'];
$sql = "SELECT * FROM teachers WHERE id != $currentUserId AND  district = '$userDistrict' AND tehsil = '$userTehsil' $searchQuery";
if (isset($_GET['center']))
{
  $ctr = $_GET['center'];
  $sql .= " AND center = '$ctr'";
}
$sql .= " LIMIT $start_from, $limit";
$result = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div
    class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
    <i class="fa-solid fa-bars d-md-none"></i>
    Welcome: <?php echo mb_convert_case($userName, MB_CASE_TITLE); ?>
  </div>
  <div class="text-danger h5">Teachers Data</div>

  <!-- Search Form -->
  <form method="GET" action="">
    <div class="input-group mb-3 ">
      <input type="hidden" name="data" value="teacher">
      <input type="text" class="form-control" name="search" placeholder="Search..." value="<?php echo $search; ?>">
      <button class="btn btn-success" type="submit">Search</button>
    </div>
  </form>

  <div class="overflow-x-scroll">
    <table id="" class="table fs-7 table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">DOB</th>
          <th scope="col">Phone</th>
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
          $sr = $start_from;
          while ($row = $result->fetch_assoc())
          {
            $sr++;
            echo "<tr>
                    <th scope='row'>{$sr}</th>
                    <td>{$row['name']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['country']}</td>
                    <td>{$row['state']}</td>
                    <td>{$row['district']}</td>
                    <td>{$row['tehsil']}</td>
                    <td>{$row['center']}</td>
                    <td>
                        <a href='edit_teacher.php?id={$row['id']}&page={$page}' class='btn btn-primary btn-sm'><i class='fa-solid fa-pen-to-square'></i></a>
                        <a href='delete_teacher.php?id={$row['id']}&page={$page}' class='btn btn-danger btn-sm' onclick='return confirmDelete()'><i class='fa-solid fa-trash'></i></a>
                    </td>
                  </tr>";
          }
        } else
        {
          echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <div class="pagination">
    <?php
    for ($i = 1; $i <= $total_pages; $i++)
    {
      echo "<a href='?data=teacher&page=" . $i . "&search=" . $search . "' class='btn btn-primary btn-sm mx-1'>" . $i . "</a>";
    }
    ?>
  </div>
</main>

<script>
  function confirmDelete() {
    return confirm('Are you sure you want to delete this record?');
  }
</script>