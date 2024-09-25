<?php include '_header.php'; ?>

<style>
    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        /* Add some space between checkboxes */
    }

    .form-item {
        display: flex;
        flex-direction: column;
    }

    .form-check {
        display: flex;
        align-items: center;
    }

    .form-check-label {
        margin-left: 10px;
    }

    /* Style the dropdown menu to match your form item */
    .dropdown-menu {
        max-height: 200px; /* Limit height for scrolling */
        overflow-y: auto;
    }

    .dropdown-toggle {
        text-align: left; /* Align dropdown text to the left */
    }

    .form-check {
        margin-bottom: 10px; /* Add space between checkboxes */
    }

    .dropdown {
        width: 100%;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none"></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE); ?>
    </div>

    <form action="../parts/teacher_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Teacher Details</div>

        <div class="row d-flex gap-1 flex-wrap fs-7">
            <!-- Dropdown for selecting Teacher/City Head types -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label class="form-label">Teacher/City Head</label>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select Types
                    </button>
                    <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                        <?php
                        $_GET['type'] = isset($_GET['type']) ? $_GET['type'] : [];
                        $arr = ['City Head', 'Teacher', 'State Head', 'Teacher 1'];
                        foreach ($arr as $value) {
                            $isChecked = in_array($value, $_GET['type']) ? 'checked' : '';
                            $onClick = $value === 'Teacher' ? 'onclick="toggleCityHead(this)"' : '';
                            echo '
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="' . $value . '" value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '" ' . $isChecked . ' ' . $onClick . '>
                                    <label class="form-check-label" for="' . $value . '">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</label>
                                </div>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <!-- Name Input -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>

            <!-- DOB Input -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" required>
            </div>

            <!-- Phone Input with validation -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                    onkeypress="return onlyDigits(event)" size="10" minlength="10" maxlength="10" required>
                <div id="phone-error" class="text-danger"></div>
            </div>

            <!-- Qualification Input -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="qualification" class="form-label">Qualification</label>
                <input type="text" class="form-control form-control-sm" id="qualification" name="qualification" required>
            </div>

            <!-- Country Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select" onchange="loadState(this)" required>
                    <option value="country">Select Country</option>
                </select>
            </div>

            <!-- State Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select" onchange="loadDistrict(this)" required>
                    <option value="state">Select State</option>
                </select>
            </div>

            <!-- District Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="district" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select" onchange="loadTehsil(this)" required>
                    <option value="dis">Select District</option>
                </select>
            </div>

            <!-- Tehsil Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select" required>
                    <option value="teh">Select Tehsil</option>
                </select>
            </div>

            <!-- Address Input -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control form-control-sm" rows="1" required></textarea>
            </div>

            <!-- Center Input -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <span>BS</span>
                    <input type="text" id="center" name="center" class="form-control form-control-sm" readonly>
                </div>
            </div>
        </div>

        <div class="text-center my-3">
            <button type="submit" class="btn btn-danger col-5">Submit</button>
        </div>
    </form>

    <script>
        // This function toggles the "City Head" checkbox when "Teacher" is selected/unselected
        function toggleCityHead(teacherCheckbox) {
            const cityHeadCheckbox = document.getElementById('City Head');
            
            // If Teacher is selected, also select City Head, otherwise uncheck it
            if (teacherCheckbox.checked) {
                cityHeadCheckbox.checked = true;
                maxCenter(teacherCheckbox);
            } else {
                cityHeadCheckbox.checked = false;
                $('#center').val(''); // Clear the center input when Teacher is unchecked
            }
        }

        // This function is triggered when the "Teacher" checkbox is clicked
        maxCenter = (e) => {
            if (e.value === 'Teacher' && e.checked) {
                console.log(e.value); // Log when Teacher is selected
                $.ajax({
                    type: "POST",
                    url: "getMaxCenter.php",
                    data: {
                        'id': 1,
                        'type': e.value
                    },
                    success: function(response) {
                        var responseObject = JSON.parse(response); // Parse the response string to an object
                        $('#center').val(responseObject.max_center + 1); // Set the center value
                    },
                    error: function(error) {
                        console.error("Error in AJAX request", error);
                    }
                });
            } else {
                $('#center').val(''); // Clear the center input if unchecked
            }
        }

        // Function to allow only digits in phone number input
        function onlyDigits(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode < 48 || charCode > 57) {
                return false;
            }
            return true;
        }
    </script>
</main>

<?php include '_footer.php'; ?>
