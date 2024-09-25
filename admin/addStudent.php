<?php 
include '_header.php';
$_SESSION['insertType'] = 'student';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="../parts/student_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Student Details</div>
        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            
            <!-- Roll No -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="roll" class="form-label">Roll No</label>
                <input type="text" class="form-control form-control-sm" id="roll" name="roll" required>
            </div>
            
            <!-- Name -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            
            <!-- Date of Birth -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input required type="date" class="form-control form-control-sm" id="dob" name="dob">
            </div>

            <!-- Father's Name -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-name" class="form-label">Father's Name</label>
                <input required type="text" class="form-control form-control-sm" id="father-name" name="father-name">
            </div>

            <!-- Father's Phone -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-phone" class="form-label">Father's Phone</label>
                <input required type="text" class="form-control form-control-sm" id="father-phone" name="father-phone">
            </div>

            <!-- Mother's Name -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-name" class="form-label">Mother's Name</label>
                <input required type="text" class="form-control form-control-sm" id="mother-name" name="mother-name">
            </div>

            <!-- Mother's Phone -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-phone" class="form-label">Mother's Phone</label>
                <input required type="text" class="form-control form-control-sm" id="mother-phone" name="mother-phone">
            </div>

            <!-- Country Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select" aria-label="Small select example"
                    required="" onchange="loadState(this)">
                    <option value="country">Country</option>
                </select>
            </div>

            <!-- State Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="stateSelect" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select" aria-label="Small select example" required=""
                    onchange="loadDistrict(this)">
                    <option value="state">State</option>
                </select>
            </div>

            <!-- District Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="districtSelect" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select" aria-label="Small select example"
                    required="" onchange="loadTehsil(this)">
                    <option value="dis">District</option>
                </select>
            </div>

            <!-- Tehsil Select -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select" aria-label="Small select example" required="">
                    <option value="teh">Tehsil</option>
                </select>
            </div>

            <!-- Address -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control form-control-sm" id="address" name="address" required>
            </div>

            <!-- Center -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input id="center" name="center" class="form-control form-control-sm" required="">
            </div>

            <!-- New Select Field for Yes/No/FOC -->
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="registerSelect" class="form-label">Student register</label>
                <select id="registerSelect" name="registerOption" class="form-select" onchange="toggleFOCInput()" required>
                    <option value="">---register-----</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="FOC">FOC (Free of Cost)</option>
                </select>
            </div>

            <!-- FOC Input Field (Initially hidden)
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0" id="focField" style="display: none;">
                <label for="foc" class="form-label">Student register</label>
                <input type="text" class="form-control form-control-sm" id="foc" name="focDetails">
            </div> -->

        </div>
        <div class="text-center my-3">
            <button type="submit" class="btn btn-danger col-5">Submit</button>
        </div>
    </form>
</main>

<?php include '_footer.php'; ?>

<!-- <script>
// JavaScript function to toggle FOC input field visibility
function toggleFOCInput() {
    var select = document.getElementById('registerSelect');
    var focField = document.getElementById('focField');

    if (select.value === 'Yes' || select.value === 'FOC') {
        focField.style.display = 'block';  // Show FOC input if 'Yes' or 'FOC' is selected
        document.getElementById('foc').setAttribute('required', true);  // Make FOC field required
    } else {
        focField.style.display = 'none';  // Hide FOC input if 'No' is selected
        document.getElementById('foc').removeAttribute('required');  // Remove required attribute
    }
}
</script> -->
