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

// Remove the trailing comma
$teacherList = rtrim($teacherList, ", ");

if($row['teacher_type'] != 'Teacher' ){
    $teacherList = '';
    }

// Now, $teacherList contains the comma-separated list of teacher names and phone numbers


    // Display teacher profile details
     '
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
                                <p class="p-0 m-0"><strong>Corporates:</strong> ' . $teacherList . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';

    ?>

    <div class=" d-flex   ">
    <img src="../imgs/Logo.png" alt="Teacher Image" class="card-img-top rounded-circle img-fluid" style="width: 50px; height: 50px; margin: auto;">
    <h5><?php echo $row['name'] ?> </h5>
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