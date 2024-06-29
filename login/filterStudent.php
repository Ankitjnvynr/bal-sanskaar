
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
          class="h2 text-center shadow-sm my-1 p-1 px-3 align-items-center  rounded-2 text-danger d-flex justify-content-between">
          <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>

          GIEO Gita-Bal Sanskaar
        </div>
  <div class="text-danger h5">Students Data</div>

        <div class="overflow-x-scroll">

          <table class="table fs-7 table-striped ">
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



                    $userName= $_SESSION['username'] ;
                    $userPhone= $_SESSION['phone'];
                    $userDistrict= $_SESSION['district'];
                    $userTehsil= $_SESSION['tehsil'];
                    $userType= $_SESSION['userType'];


              include '../config/_db.php'; // include the database connection
              $sql = "SELECT * FROM students WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil' ";
              if(isset($_GET['center']) || $_GET['center']!=='' ){
                $ctr = $_GET['center'];
                $sql = "SELECT * FROM students WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil' AND `center`= '$ctr'";
      
              }
              $result = $conn->query($sql);

              if ($numrow = $result->num_rows > 0)
              {
                echo $result->num_rows." records found";
                $sr=0;
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
