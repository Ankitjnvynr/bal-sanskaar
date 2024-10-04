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

include '../config/_db.php'; // include the database connection

$limit = 10; // Number of entries to show per page
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$start_from = ($page - 1) * $limit;

// Initialize search variables
$searchQuery = '';
$search = '';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $searchQuery = " AND (name LIKE '%$search%' OR phone LIKE '%$search%' OR center LIKE '%$search%')";
}

// Fetch total records for pagination
$total_records_query = "SELECT COUNT(*) FROM teachers WHERE id != $currentUserId AND `state` = '{$_SESSION['state']}' $searchQuery";
if ($userType == 'City Head') {
  $total_records_query .= " AND `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
}
if (isset($_GET['center'])) {
  $ctr = $_GET['center'];
  $total_records_query .= " AND center = '$ctr'";
}
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_row()[0];
$total_pages = ceil($total_records / $limit);

// Fetch records for the current page
$currentUserId = $_SESSION['id'];
$sql = "SELECT * FROM teachers WHERE id != $currentUserId AND `state` = '{$_SESSION['state']}' $searchQuery";
if ($userType == 'City Head') {
  $sql .= " AND `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
}
if (isset($_GET['center'])) {
  $ctr = $_GET['center'];
  $sql .= " AND center = '$ctr'";
}
$sql .= " LIMIT $start_from, $limit";
$result = $conn->query($sql);
?>
<style>
        .pagination {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .page-item {
            margin: 0 5px;
        }
        .page-link {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .page-link:hover {
            background-color: #e9ecef;
            color: #0056b3;
        }
        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
        }
    </style>

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
      <input type="text" class="form-control" name="search" placeholder="Search..."
        value="<?php echo $search; ?>">
      <button class="btn btn-danger" type="submit">Search</button>
    </div>
  </form>

  <div class="overflow-x-scroll">
    <table id="" class="table fs-7 table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <?php
          if ($_SESSION['userType'] == 'State Head') {
            echo '<th scope="col">Type</th>';
          }
          ?>
          <th scope="col">Teacher </th>
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
        if ($result->num_rows > 0) {
          $sr = $start_from;
          while ($row = $result->fetch_assoc()) {
            $sr++;
            echo "<tr>
                    <th scope='row'>{$sr}</th>
                    ";
        ?>
            <?php
            if ($_SESSION['userType'] == 'State Head' || $_SESSION['userType'] == 'City Head') {
            ?>
             
        <?php
            }
            echo "
                    <td class='lh-1 text-nowrap' >{$row['teacher_type']}</td>
                    <td class='lh-1 text-nowrap' >{$row['name']}</td>
                    <td class='lh-1 text-nowrap' >{$row['dob']}</td>
                    <td class='lh-1 text-nowrap' >{$row['phone']}</td>
                    <td class='lh-1 text-nowrap' >{$row['qualification']}</td>
                    <td class='lh-1 text-nowrap' >{$row['country']}</td>
                    <td class='lh-1 text-nowrap' >{$row['state']}</td>
                    <td class='lh-1 text-nowrap' >{$row['district']}</td>
                    <td class='lh-1 text-nowrap' >{$row['tehsil']}</td>
                    <td class='lh-1 text-nowrap' >{$row['center']}</td>
                    <td>
                        <a href='edit_teacher.php?id={$row['id']}&page={$page}' class='btn btn-primary btn-sm'><i class='fa-solid fa-pen-to-square'></i></a>
                        <a href='delete_teacher.php?id={$row['id']}&page={$page}' class='btn btn-danger btn-sm' onclick='return confirmDelete()'><i class='fa-solid fa-trash'></i></a>
                    </td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

    <!-- Custom Pagination -->
    <div class="pagination">
        <?php
        $range = 2; // Number of page links to show around the current page
        $start_page = max(1, $page - $range);
        $end_page = min($total_pages, $page + $range);

        // Previous button
        if ($page > 1) {
            echo "<a href='?data=teacher&page=" . ($page - 1) . "&search=" . urlencode($search) . "' class='page-link'>&laquo;</a>";
        }

        // First page
        if ($start_page > 1) {
            echo "<a href='?data=teacher&page=1&search=" . urlencode($search) . "' class='page-link'>1</a>";
            if ($start_page > 2) {
                echo "<span class='page-link'>...</span>";
            }
        }

        // Page links
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $page) {
                echo "<a href='#' class='page-item active page-link'>$i</a>";
            } else {
                echo "<a href='?data=teacher&page=$i&search=" . urlencode($search) . "' class='page-link'>$i</a>";
            }
        }

        // Last page
        if ($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) {
                echo "<span class='page-link'>...</span>";
            }
            echo "<a href='?data=teacher&page=$total_pages&search=" . urlencode($search) . "' class='page-link'>$total_pages</a>";
        }

        // Next button
        if ($page < $total_pages) {
            echo "<a href='?data=teacher&page=" . ($page + 1) . "&search=" . urlencode($search) . "' class='page-link'>&raquo;</a>";
        }
        ?>
    </div>
</main>

<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this record?');
}

function changeTeacherType(id, e) {
    $.ajax({
        url: '../admin/changeTeacherType.php',
        type: 'POST',
        data: {
            id: id,
            type: e.value
        },
        dataType: 'json',
        success: function(res) {
            console.log(typeof res);
            e.parentNode.parentNode.childNodes[21].innerHTML = res.center;
        },
        error: function(xhr, status, error) {
            console.error('Error:', status, error);
        }
    });
}
</script>