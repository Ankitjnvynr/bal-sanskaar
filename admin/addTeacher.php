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
    max-height: 200px;
    /* Limit height for scrolling */
    overflow-y: auto;
}

.dropdown-toggle {
    text-align: left;
    /* Align dropdown text to the left */
}

.form-check {
    margin-bottom: 10px;
    /* Add space between checkboxes */
}

.dropdown {
    width: 100%;
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form id="teacherForm" action="../parts/teacher_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Teacher Details</div>

        <div class="row d-flex gap-1 flex-wrap fs-7">
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label class="form-label">Teacher/City Head</label>
                <!-- Custom styled dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select Types
                    </button>
                    <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                        <?php
                        $arr = ['City Head', 'Teacher', 'State Head', 'Teacher1'];
                        foreach ($arr as $value) {
                            echo '
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '" onchange="handleCheckboxChange(this)">
                                    <label class="form-check-label">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</label>
                                </div>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" required>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                    onkeypress="return onlyDigits(event)" size="10" minlength="10" maxlength="10" required>
                <div id="phone-error" class="text-danger"></div>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="qualification" class="form-label">Qualification</label>
                <input type="text" class="form-control form-control-sm" id="qualification" name="qualification">
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select" aria-label="Small select example" 
                    onchange="loadState(this)" required>
                    <option value="country">Country</option>
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select" aria-label="Small select example" 
                    onchange="loadDistrict(this)" required>
                    <option value="state">State</option>
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="district" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select" aria-label="Small select example"
                    required onchange="loadTehsil(this)" required>
                    <option value="dis">District</option>
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select" aria-label="Small select example" required>
                    <option value="teh">Tehsil</option>
                </select>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control form-control-sm" rows="1"></textarea>
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <span>BS</span>
                    <input type="text" id="center" name="center" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dt" class="form-label">Join On</label>
                <input type="date" id="dt" name="dt" class="form-control form-control-sm">
            </div>

            <script>
            // Set current date by default
            document.addEventListener('DOMContentLoaded', function() {
                var today = new Date().toISOString().split('T')[0];
                document.getElementById('dt').value = today;
            });
            </script>

        </div>

        <div class="text-center my-3">
            <button type="submit" class="btn btn-danger col-5">Submit</button>
        </div>
    </form>

    <script>
    // Function to handle checkbox changes and run maxCenter only when 'Teacher' is selected
    function handleCheckboxChange(e) {
        if (e.value === 'Teacher' && e.checked) {
            maxCenter(e); // Run maxCenter if 'Teacher' is checked
        } else if (e.value === 'Teacher' && !e.checked) {
            $('#center').val(''); // Clear the center input if 'Teacher' is unchecked
        }
    }

    // Function to get max center for 'Teacher'
    function maxCenter(e) {
        console.log(e.value); // Log when 'Teacher' is selected
        $.ajax({
            type: "POST",
            url: "getMaxCenter.php",
            data: {
                'id': 1,
                'type': e.value
            },
            success: function(response) {
                console.log(response);
                var responseObject = JSON.parse(response); // Parse the response string to an object
                $('#center').val(responseObject.max_center + 1); // Set the center value
            }
        });
    }

    // Concatenate selected teacher types into a comma-separated string before submitting the form
    document.getElementById('teacherForm').addEventListener('submit', function(event) {
        // Get all checked checkboxes
        const checkboxes = document.querySelectorAll('input[name="type[]"]:checked');
        const selectedValues = Array.from(checkboxes).map(cb => cb.value).join(',');

        // Create a hidden input with the concatenated string
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'type';
        hiddenInput.value = selectedValues;

        // Append the hidden input to the form
        this.appendChild(hiddenInput);
    });

    // Function for digits only in phone input
    function onlyDigits(event) {
        let charCode = event.charCode ? event.charCode : event.keyCode;
        if (charCode < 48 || charCode > 57) {
            event.preventDefault();
        }
    }
    </script>
</main>

<?php include '_footer.php'; ?>