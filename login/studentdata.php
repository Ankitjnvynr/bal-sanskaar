<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
  <div
    class="h4 text-center shadow-sm my-1 p-1 align-items-center  rounded-2 text-danger d-flex justify-content-between">
    <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
    Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
  </div>
  <div class="text-danger h5">Students Data</div>

  <div class="overflow-x-scroll">

    <table id="myTable" class="table fs-7 table-striped ">
      <thead>
        <tr>
          <th scope="col">ID</th>
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
          <th scope="col">Center</th>
        </tr>
      </thead>
      <tbody>
        <?php



        $userName = $_SESSION['username'];
        $userPhone = $_SESSION['phone'];
        $userDistrict = $_SESSION['district'];
        $userTehsil = $_SESSION['tehsil'];
        $userType = $_SESSION['userType'];
        $userCenter = $_SESSION['userCenter'];


        include '../config/_db.php'; // include the database connection
        $sql = "SELECT * FROM students WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil' ";
        if ($userType == 'Teacher')
        {
          $sql = "SELECT * FROM students WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil' AND `center`='$userCenter' ";
        }
        $result = $conn->query($sql);

        if ($numrow = $result->num_rows > 0)
        {
          echo $result->num_rows . " records found";
          $sr = 0;
          while ($row = $result->fetch_assoc())
          {
            $sr++;
            echo "<tr>
                              <th scope='row'>{$sr}</th>
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
                              <td>{$row['center']}</td>
                          </tr>";
          }
        } else
        {
          echo "<tr><td colspan='12' class='text-center'>No records found</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</main>