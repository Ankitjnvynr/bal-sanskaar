<?php
include '../config/_db.php';

// Retrieve teacher ID from POST request
$teacherId = $_POST['teacher_id'];

// Prepare and execute SQL query to fetch teacher data
$sql = "SELECT * FROM teachers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();



// Check if teacher exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $corporateSQL = "SELECT name, phone FROM teachers WHERE center = ?";
$stmt = $conn->prepare($corporateSQL);
$stmt->bind_param("i", $row['center']);
$stmt->execute();
$c_result = $stmt->get_result();

$teacherList = "";
while ($c_row = $c_result->fetch_assoc()) {
    $teacherList .= $c_row['name'] . " (" . $c_row['phone'] . "), ";
}
$c_center = $row['center'];
// Remove the trailing comma
$teacherList = rtrim($teacherList, ", ");

if($row['teacher_type'] != 'Teacher' ){
    $teacherList = '';
    }

// Now, $teacherList contains the comma-separated list of teacher names and phone numbers


    // Display teacher profile details
    echo '
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>' . $row['name'] . ' (' . $row['teacher_type'] . ')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="../imgs/Logo.png" alt="Teacher Image" class="card-img-top rounded-circle img-fluid"
                                    style="width: 150px; height: 150px; margin: auto;">
                            </div>
                            <div class="col-8">
                                <p class="p-0 m-0"><strong>DOB:</strong> ' . $row['dob'] . '</p>
                                <p class="p-0 m-0"><strong>Phone:</strong> ' . $row['phone'] . '</p>
                                <p class="p-0 m-0"><strong>Qualification:</strong> ' . $row['qualification'] . '.</p>
                                <p class="p-0 m-0"><strong>Address:</strong> ' . $row['address'] . ', ' . $row['tehsil'] . ', ' . $row['district'] . ', ' . $row['state'] . '.</p>
                                <p class="p-0 m-0"><strong>Center Number:</strong> ' . $row['center'] . '</p>
                                <p class="p-0 m-0"><strong>Center Start on:</strong> ' . $row['dt'] . '</p>
                                
                                <details>
                                <summary ><span class="btn btn-success btn-sm">Add Corporates</span></summary>
      <form class="mt-4">
        <div class="row g-3">
          <!-- Name -->
          <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name">
          </div>

          <!-- DOB -->
          <div class="col-md-6">
            <label for="dob" class="form-label">DOB</label>
            <input type="date" class="form-control" id="dob">
          </div>

          <!-- Phone -->
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" placeholder="Enter phone number">
          </div>

          <!-- Qualification -->
          <div class="col-md-6">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" class="form-control" id="qualification" placeholder="Enter qualification">
          </div>

          <!-- Address -->
          <div class="col-md-12">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" placeholder="Enter address">
          </div>

          <!-- Hidden Fields -->
          <input type="hidden" id="type" value="Teacher">
          <input type="hidden" id="state" value="State">
          <input type="hidden" id="district" value="District">
          <input type="hidden" id="tehsil" value="'. $row['tehsil'] .'">
          <input type="hidden" id="center" value="Center">

          <!-- Submit Button -->
          <div class="col-md-12">
            <button type="submit" class="btn submit-btn">Submit</button>
          </div>
        </div>
      </form>
    </details>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';

    ?>

<div class="card">
    <div class="card-header">
        <h5>Related
            <?php if($row['teacher_type']!='Teacher') echo '<span onclick="showTeacherList()" class="btn btn-warning btn-sm">Teachers</span> &';  ?>
            <span onclick="showStudentList()" class="btn btn-primary btn-sm">Students</span> & 
            <span onclick="showAssociatesList()" class="btn btn-success btn-sm">Corporates</span> </h5>
    </div>
    <div class="card-body">
        <div style="height:30vh" class="row overflow-y-scroll">
            <div id="teacher-list" hidden class="col-md-12 bg-warning-subtle">
                <?php
                    // Retrieve filter values from POST request
                    $center = $row['center'];
                    $country = $row['country'];
                    $state = $row['state'];
                    $tehsil = $row['tehsil'];
                    $district = $row['district'];

                    // Build WHERE clause based on filter values
                    $whereClause = "";
                    if (!empty($country)) {
                        $whereClause .= "  country = '$country'";
                    }
                    
                    if (!empty($state)) {
                        $whereClause .= " AND state = '$state'";
                    }
                    if (!empty($tehsil)) {
                        $whereClause .= " AND tehsil = '$tehsil'";
                    }
                    if (!empty($district)) {
                        $whereClause .= " AND district = '$district'";
                    }
                    // Prepare and execute SQL query to fetch student data
                   $t_sql = "SELECT * FROM teachers WHERE " . $whereClause;
                    $t_result = $conn->query($t_sql);
                    // Display student data in a table
                    echo '
                    <table  class="table bg-warning-subtle">
                        <thead>
                            <tr>
                                <th>Teacher Type</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>DOB</th>                                
                                <th>Qualification</th>                                
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Tehsil</th>
                                <th>Address</th>
                                <th>Center</th>
                            </tr>
                        </thead>
                        <tbody>';

                    if ($t_result->num_rows > 0) {
                        echo "<h6>Total Teachers: ".$t_result->num_rows."</h6><hr>"; 
                        while ($t_row = $t_result->fetch_assoc()) {
                            echo '
                            <tr>
                                <td>' . $t_row['teacher_type'] . '</td>
                                <td>' . $t_row['name'] . '</td>
                                <td>' . $t_row['phone'] . '</td>
                                <td>' . $t_row['dob'] . '</td>
                                <td>' . $t_row['qualification'] . '</td>                                
                                <td>' . $t_row['country'] . '</td>
                                <td>' . $t_row['state'] . '</td>
                                <td>' . $t_row['district'] . '</td>
                                <td>' . $t_row['tehsil'] . '</td>
                                <td>' . $t_row['address'] . '</td>
                                <td>' . $t_row['center'] . '</td>
                               
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="16">No data found.</td></tr>';
                    }

                    echo '
                        </tbody>
                    </table>';
                    ?>

            </div>
            <div id="associates-list" hidden class="col-md-12 bg-warning-subtle">
                <?php
                    // Retrieve filter values from POST request
                    $center = $row['center'];
                    $country = $row['country'];
                    $state = $row['state'];
                    $tehsil = $row['tehsil'];
                    $district = $row['district'];

                    // Build WHERE clause based on filter values
                    $whereClause = "";
                    if (!empty($country)) {
                        $whereClause .= "  country = '$country'";
                    }
                    
                    if (!empty($state)) {
                        $whereClause .= " AND state = '$state'";
                    }
                    if (!empty($tehsil)) {
                        $whereClause .= " AND tehsil = '$tehsil'";
                    }
                    if (!empty($district)) {
                        $whereClause .= " AND district = '$district'";
                    }
                    $whereClause .= " AND center = '$c_center'";
                    // Prepare and execute SQL query to fetch student data
                   $t_sql = "SELECT * FROM teachers WHERE " . $whereClause;
                    $t_result = $conn->query($t_sql);
                    // Display student data in a table
                    echo '
                    <table  class="table bg-warning-subtle">
                        <thead>
                            <tr>
                                <th>Teacher Type</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>DOB</th>                                
                                <th>Qualification</th>                                
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Tehsil</th>
                                <th>Address</th>
                                <th>Center</th>
                            </tr>
                        </thead>
                        <tbody>';

                    if ($t_result->num_rows > 0) {
                        echo "<h6>Total Associates: ".$t_result->num_rows."</h6><hr>"; 
                        while ($t_row = $t_result->fetch_assoc()) {
                            echo '
                            <tr>
                                <td>' . $t_row['teacher_type'] . '</td>
                                <td>' . $t_row['name'] . '</td>
                                <td>' . $t_row['phone'] . '</td>
                                <td>' . $t_row['dob'] . '</td>
                                <td>' . $t_row['qualification'] . '</td>                                
                                <td>' . $t_row['country'] . '</td>
                                <td>' . $t_row['state'] . '</td>
                                <td>' . $t_row['district'] . '</td>
                                <td>' . $t_row['tehsil'] . '</td>
                                <td>' . $t_row['address'] . '</td>
                                <td>' . $t_row['center'] . '</td>
                               
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="16">No data found.</td></tr>';
                    }

                    echo '
                        </tbody>
                    </table>';
                    ?>

            </div>
            <div id="student-list" class="col-md-12">
                <?php
                    // Retrieve filter values from POST request
                    $center = $row['center'];
                    $country = $row['country'];
                    $state = $row['state'];
                    $tehsil = $row['tehsil'];
                    $district = $row['district'];

                    // Build WHERE clause based on filter values
                    $whereClause = "";
                    if (!empty($country)) {
                        $whereClause .= "  country = '$country'";
                    }
                    if (!empty($center)) {
                        $whereClause .= " AND center = '$center'";
                    }
                    if (!empty($state)) {
                        $whereClause .= " AND state = '$state'";
                    }
                    if (!empty($tehsil)) {
                        $whereClause .= " AND tehsil = '$tehsil'";
                    }
                    if (!empty($district)) {
                        $whereClause .= " AND district = '$district'";
                    }

                    // Prepare and execute SQL query to fetch student data
                   $s_sql = "SELECT * FROM students WHERE " . $whereClause;
                   
                    $s_result = $conn->query($s_sql);
                

                    // Display student data in a table
                    echo '
                    <table class="table">
                        <thead>
                            <tr>
                               
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Father Name</th>
                                <th>Father Phone</th>
                                
                                <th>Mother Name</th>
                                <th>Mother Phone</th>
                               
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Tehsil</th>
                                <th>Address</th>
                               
                            </tr>
                        </thead>
                        <tbody>';

                    if ($s_result->num_rows > 0) {
                        echo "<h6>Total Students: ".$s_result->num_rows."</h6><hr>"; 
                        while ($Student_row = $s_result->fetch_assoc()) {
                            echo '
                            <tr>
                                <td>' . $Student_row['rollno'] . '</td>
                                <td>' . $Student_row['name'] . '</td>
                                <td>' . $Student_row['dob'] . '</td>
                                <td>' . $Student_row['father_name'] . '</td>
                                <td>' . $Student_row['father_phone'] . '</td>
                                <td>' . $Student_row['mother_name'] . '</td>
                                <td>' . $Student_row['mother_phone'] . '</td>
                                <td>' . $Student_row['country'] . '</td>
                                <td>' . $Student_row['state'] . '</td>
                                <td>' . $Student_row['district'] . '</td>
                                <td>' . $Student_row['tehsil'] . '</td>
                                <td>' . $Student_row['address'] . '</td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="16">No data found.</td></tr>';
                    }

                    echo '
                        </tbody>
                    </table>';
                    ?>




            </div>
        </div>
    </div>
</div>





</div>
</div>
</div>


<?php
} else {
    echo "Teacher not found.";
}

$stmt->close();
$conn->close();
?>