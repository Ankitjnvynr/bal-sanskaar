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
$total_records_query = "SELECT COUNT(*) FROM teachers WHERE   id != $currentUserId AND  `state` = '{$_SESSION['state']}' $searchQuery";
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
$sql = "SELECT * FROM teachers WHERE id != $currentUserId AND  `state` = '{$_SESSION['state']}' $searchQuery";
if ($userType == 'Head Teacher')
{
  $sql .= " AND `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
}
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
      <button class="btn btn-danger" type="submit">Search</button>
    </div>
  </form>

  <div class="overflow-x-scroll">
    <table id="" class="table fs-7 table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <?php
          if ($_SESSION['userType'] == 'State Head')
          {
            echo '<th scope="col">Type</th>';
          }
          ?>
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
          $sr = $start_from;
          while ($row = $result->fetch_assoc())
          {
            $sr++;
            echo "<tr>
                    <th scope='row'>{$sr}</th>
                    ";
            ?>
            <?php
            if ($_SESSION['userType'] == 'State Head')
            {
              ?>
              <td>
                <select class="border" onchange="changeTeacherType(<?php echo $row['id']; ?>,this)">
                  <?php
                  $arr = ['Teacher', 'Head Teacher',];
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
              <?php
            }
            echo "
                    <td>{$row['name']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['qualification']}</td>
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
  changeTeacherType = (id, e) => {
    $.ajax({
      url: '../admin/changeTeacherType.php',
      type: 'POST',
      data: {
        id: id,
        type: e.value
      },
      dataType: 'json', // Ensures the response is parsed as JSON
      success: function (res) {
        // Check if the response is a JavaScript object
        console.log(typeof res);

        // Assuming the 10th child element is the one you want to update
        e.parentNode.parentNode.childNodes[21].innerHTML = res.center;
      },
      error: function (xhr, status, error) {
        console.error('Error:', status, error);
      }
    });
  }
</script>