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
?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?php echo $row['name']; ?> (<?php echo $row['teacher_type']; ?>)</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <img src="../imgs/Logo.png" alt="Teacher Image"
                                class="card-img-top rounded-circle img-fluid"
                                style="width: 150px; height: 150px; margin: auto;">
                        </div>
                        <div class="col-8">
                            <p class="p-0 m-0"><strong>DOB:</strong> <?php echo $row['dob']; ?></p>
                            <p class="p-0 m-0"><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                            <p class="p-0 m-0"><strong>Qualification:</strong> <?php echo $row['qualification']; ?>.</p>
                            <p class="p-0 m-0"><strong>Address:</strong> <?php echo $row['address']; ?>,
                                <?php echo $row['tehsil']; ?>, <?php echo $row['district']; ?>,
                                <?php echo $row['state']; ?>.</p>
                            <p class="p-0 m-0"><strong>Center Number:</strong> <?php echo $row['center']; ?></p>
                            <p class="p-0 m-0"><strong>Center Start on:</strong> <?php echo $row['dt']; ?></p>
                            <details>
                                <summary><span class="btn btn-success btn-sm">Add Corporates</span></summary>

                                <form class="mt-4" id="subteacherForm">
                                    <div class="row g-3">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label for="subteacher_name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="subteacher_name"
                                                placeholder="Enter name" required>
                                        </div>

                                        <!-- DOB -->
                                        <div class="col-md-6">
                                            <label for="subteacher_dob" class="form-label">DOB</label>
                                            <input type="date" class="form-control" id="subteacher_dob" required>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <label for="subteacher_phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="subteacher_phone"
                                                placeholder="Enter phone number" required>
                                        </div>

                                        <!-- Qualification -->
                                        <div class="col-md-6">
                                            <label for="subteacher_qualification"
                                                class="form-label">Qualification</label>
                                            <input type="text" class="form-control" id="subteacher_qualification"
                                                placeholder="Enter qualification" required>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-12">
                                            <label for="subteacher_address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="subteacher_address"
                                                placeholder="Enter address" required>
                                        </div>

                                        <!-- Hidden Fields -->
                                        <input type="hidden" id="subteacher_type" value="Teacher">
                                        <input type="hidden" id="subteacher_state" value="State">
                                        <input type="hidden" id="subteacher_district" value="District">
                                        <input type="hidden" id="subteacher_tehsil"
                                            value="<?php echo $row['tehsil']; ?>">
                                        <input type="hidden" id="subteacher_center" value="Center">

                                        <!-- Submit Button -->
                                        <div class="col-md-12">
                                            <button type="button" onclick="submitSubteacher(
                                            '<?php echo addslashes($row['country']); ?>', 
                                            '<?php echo addslashes($row['state']); ?>', 
                                            '<?php echo addslashes($row['district']); ?>', 
                                            '<?php echo addslashes($row['tehsil']); ?>', 
                                            '<?php echo addslashes($row['center']); ?>'
                                        )" class="btn submit-btn">Submit</button>
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
<?php
?>

// related teachers and students and corporates
<div class="card">

    <div class="card-body">
        <h5>Related
            <span onclick="fetchTeachers()" class="btn btn-warning btn-sm">Teachers</span> &
            <span onclick="fetchStudents()" class="btn btn-primary btn-sm">Students</span> &
            <span onclick="fetchCorporates()" class="btn btn-success btn-sm">Corporates</span>
        </h5>
        <div id="related-data" style="height:30vh; overflow-y: scroll;"></div>
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






<script>
function fetchTeachers() {
    $.ajax({
        url: 'fetch_teachers.php',
        type: 'POST',
        data: {
            country: '<?php echo $row['country']; ?>',
            state: '<?php echo $row['state']; ?>',
            tehsil: '<?php echo $row['tehsil']; ?>',
            district: '<?php echo $row['district']; ?>'
        },
        success: function(response) {
            $('#related-data').html(response);
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
        }
    });
}

function fetchStudents() {
    $.ajax({
        url: 'fetch_students.php',
        type: 'POST',
        data: {
            country: '<?php echo $row['country']; ?>',
            state: '<?php echo $row['state']; ?>',
            tehsil: '<?php echo $row['tehsil']; ?>',
            district: '<?php echo $row['district']; ?>',
            center: '<?php echo $row['center']; ?>'
        },
        success: function(response) {
            $('#related-data').html(response);
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
        }
    });
}

function fetchCorporates() {
    $.ajax({
        url: 'fetch_corporates.php',
        type: 'POST',
        data: {
            country: '<?php echo $row['country']; ?>',
            state: '<?php echo $row['state']; ?>',
            tehsil: '<?php echo $row['tehsil']; ?>',
            district: '<?php echo $row['district']; ?>',
            center: '<?php echo $row['center']; ?>'
        },
        success: function(response) {
            $('#related-data').html(response);
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
        }
    });
}
</script>
<script>
function submitSubteacher(country, state, district, tehsil, center) {
    // Collecting form data from visible fields
    const name = $('#subteacher_name').val();
    const dob = $('#subteacher_dob').val();
    const phone = $('#subteacher_phone').val();
    const qualification = $('#subteacher_qualification').val();
    const address = $('#subteacher_address').val();

    // Creating an object to hold the data
    const data = {
        name: name,
        dob: dob,
        phone: phone,
        qualification: qualification,
        address: address,
        type: 'Teacher1', // Adjust if necessary
        country: country,
        state: state,
        district: district,
        tehsil: tehsil,
        center: center
    };

    // Sending the AJAX request with jQuery
    $.ajax({
        url: '../parts/teacher_form.php',
        type: 'POST',
        data: data, // Sending data as plain object
        success: function(response) {
            console.log(response);

            $('#subteacher_name').val('');
            $('#subteacher_dob').val('');
            $('#subteacher_phone').val('');
            $('#subteacher_qualification').val('');
            $('#subteacher_address').val('');
            fetchCorporates()
            
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
        }
    });
}
</script>