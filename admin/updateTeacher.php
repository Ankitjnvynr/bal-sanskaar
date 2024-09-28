<?php
require_once '../config/_db.php';

$user_id = isset($_GET['user']) ? intval($_GET['user']) : 0;
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

<?php include '_header.php'; ?>

<style>
    .dropdown-menu {
        max-height: 200px; /* Limit height */
        overflow-y: auto; /* Scroll if too long */
    }

    .dropdown-item {
        display: flex;
        align-items: center;
    }

    .dropdown-item input {
        margin-right: 5px;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none"></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="../parts/teacher_update.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Teacher Details</div>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user_id); ?>">

        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="type" class="form-label">Teacher Roles</label>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Roles
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php
                        $roles = ['City Head', 'Teacher', 'State Head', 'Teacher1'];
                        $selected_roles = $teacher ? explode(',', $teacher['teacher_type']) : [];
                        foreach ($roles as $value) {
                            $checked = in_array($value, $selected_roles) ? 'checked' : '';
                            $onChangeEvent = ($value === 'Teacher') ? 'onchange="maxCenter(this)"' : ''; // Only for Teacher role
                            echo '<div class="dropdown-item">
                                    <input type="checkbox" name="teacher_type[]" value="' . htmlspecialchars($value) . '" ' . $checked . ' ' . $onChangeEvent . '>
                                    <label>' . htmlspecialchars($value) . '</label>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

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
                <label for="qualification" class="form-label">Qualification</label>
                <input type="text" class="form-control form-control-sm" id="qualification" name="qualification" value="<?php echo htmlspecialchars($teacher['qualification'] ?? ''); ?>">
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select" required onchange="loadState(this)">
                    <option value="">Select Country</option>
                    <!-- Populate with countries -->
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select" required onchange="loadDistrict(this)">
                    <option value="">Select State</option>
                    <!-- Populate with states -->
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="district" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select" required onchange="loadTehsil(this)">
                    <option value="">Select District</option>
                    <option value="district1" <?php echo ($teacher && $teacher['district'] == 'district1') ? 'selected' : ''; ?>>District1</option>
                    <option value="district2" <?php echo ($teacher && $teacher['district'] == 'district2') ? 'selected' : ''; ?>>District2</option>
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select" required>
                    <option value="">Select Tehsil</option>
                    <option value="tehsil1" <?php echo ($teacher && $teacher['tehsil'] == 'tehsil1') ? 'selected' : ''; ?>>Tehsil1</option>
                    <option value="tehsil2" <?php echo ($teacher && $teacher['tehsil'] == 'tehsil2') ? 'selected' : ''; ?>>Tehsil2</option>
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input type="text" id="center" name="center" class="form-control form-control-sm" value="<?php echo htmlspecialchars($teacher['center'] ?? ''); ?>">
            </div>

            <?php
            $dt = $teacher['dt'] ?? '';
            if (!empty($dt)) {
                $dt = date('Y-m-d', strtotime($dt));
            }
            ?>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dt" class="form-label">Join On</label>
                <input type="date" id="dt" name="dt" class="form-control form-control-sm" value="<?php echo htmlspecialchars($dt); ?>">
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control form-control-sm" rows="2"><?php echo htmlspecialchars($teacher['address'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="text-center my-3">
            <button type="submit" class="btn btn-danger col-5">Update</button>
        </div>
    </form>
</main>

<script>
updating = true;
currentCountry = '<?php echo htmlspecialchars($teacher['country'] ?? ''); ?>';
currentState = '<?php echo htmlspecialchars($teacher['state'] ?? ''); ?>';
currentDistrict = '<?php echo htmlspecialchars($teacher['district'] ?? ''); ?>';
currentTehsil = '<?php echo htmlspecialchars($teacher['tehsil'] ?? ''); ?>';

// This function is triggered when the "Teacher" checkbox is clicked
maxCenter = (e) => {
    if (e.checked) {
        console.log(e.value); // Log when Teacher is selected
        $.ajax({
            type: "POST",
            url: "getMaxCenter.php",
            data: {
                'id': 1,
                'type': e.value
            },
            success: function(response) {
                console.log(response);
                var responseObject = JSON.parse(response);
                 // Parse the response string to an object
                $('#center').val(responseObject.max_center + 1); // Set the center value
            }
        });
    } else {
        $('#center').val(''); // Clear the center input if unchecked
    }
}
</script>

<?php include '_footer.php'; ?>
