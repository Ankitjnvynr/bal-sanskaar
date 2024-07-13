<?php include '_header.php'; ?>
<?php

require_once '../config/_db.php';

$user_id = $_SESSION['id'];
$teacher = null;

if ($user_id > 0) {
    // Fetch existing data
    $sql_fetch = "SELECT * FROM teachers WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $user_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    }
    $stmt_fetch->close();
}
?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="../parts/teacher_update.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Your Details</div>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user_id); ?>">

        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" value="<?php echo htmlspecialchars($teacher['name'] ?? ''); ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" value="<?php echo htmlspecialchars($teacher['dob'] ?? ''); ?>">
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" id="phone" name="phone" onkeypress="return onlyDigits(event)" size="10" minlength="10" maxlength="10" value="<?php echo htmlspecialchars($teacher['phone'] ?? ''); ?>">
                <div id="phone-error" class="text-danger"></div>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select" required onchange="loadState(this)">
                    <option value="">Select Country</option>
                    <option value="country1" <?php echo ($teacher && $teacher['country'] == 'country1') ? 'selected' : ''; ?>>Country1</option>
                    <option value="country2" <?php echo ($teacher && $teacher['country'] == 'country2') ? 'selected' : ''; ?>>Country2</option>
                    <!-- Add more options as necessary -->
                </select>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select" required onchange="loadDistrict(this)">
                    <option value="">Select State</option>
                    <option value="state1" <?php echo ($teacher && $teacher['state'] == 'state1') ? 'selected' : ''; ?>>
                        State1</option>
                    <option value="state2" <?php echo ($teacher && $teacher['state'] == 'state2') ? 'selected' : ''; ?>>
                        State2</option>
                    <!-- Add more options as necessary -->
                </select>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="district" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select" required onchange="loadTehsil(this)">
                    <option value="">Select District</option>
                    <option value="district1" <?php echo ($teacher && $teacher['district'] == 'district1') ? 'selected' : ''; ?>>District1</option>
                    <option value="district2" <?php echo ($teacher && $teacher['district'] == 'district2') ? 'selected' : ''; ?>>District2</option>
                    <!-- Add more options as necessary -->
                </select>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select" required>
                    <option value="">Select Tehsil</option>
                    <option value="tehsil1" <?php echo ($teacher && $teacher['tehsil'] == 'tehsil1') ? 'selected' : ''; ?>>Tehsil1</option>
                    <option value="tehsil2" <?php echo ($teacher && $teacher['tehsil'] == 'tehsil2') ? 'selected' : ''; ?>>Tehsil2</option>
                    <!-- Add more options as necessary -->
                </select>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input disabled type="text" id="center" name="center" class="form-control form-control-sm" value="<?php echo htmlspecialchars($teacher['center'] ?? ''); ?>">
            </div>

        </div>
        <div class="text-center my-3"><button type="submit" class="btn btn-danger col-5">Update</button></div>
    </form>

    <hr>
    <div class="accordion fs-7" id="accordionPanelsStayOpenExample">
        <div class="accordion-item accordion-item-sm">
            <h2 class="accordion-header ">
                <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Change Password
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse ">
                <div class="accordion-body">
                    <form class="row d-flex gap-1 flex-wrap fs-7 px-2" id="changePasswordForm">
                        <div class="form-item">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control form-control-sm" id="currentPassword" name="current_password" required>
                        </div>
                        <div class="form-item">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control form-control-sm" id="newPassword" name="new_password" required>
                        </div>
                        <div class="form-item">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control form-control-sm" id="confirmPassword" name="confirm_password" required>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-danger">Change Password</button>
                        </div>
                        <div id="message" class="mt-3 text-center"></div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
</main>
<script>
    
    // password change funciton 
    $(document).ready(function() {
        
        $('#changePasswordForm').on('submit', function(event) {
            event.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '../parts/change_password.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#changePasswordForm')[0].reset(); // Clear the form
                        setTimeout(() => {
                            const collapseElement = new bootstrap.Collapse($('#panelsStayOpen-collapseOne'));
                            $('#message').html('');
                            collapseElement.hide();// Close the accordion
                        }, 4000);
                    } else {
                        $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function() {
                    $('#message').html('<div class="alert alert-danger">An error occurred while processing the request.</div>');
                }
            });
        });
    });
</script>

<?php include '_footer.php'; ?>