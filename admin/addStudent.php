<?php 
include '_header.php';
$_SESSION['insertType'] = 'student';

    ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center  rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="../parts/student_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Student Details</div>
        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Roll No</label>
                <input type="text" class="form-control form-control-sm" id="roll" name="roll" required>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input required type="date" class="form-control form-control-sm" id="dob" name="dob">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-name" class="form-label">Father's Name</label>
                <input required type="text" class="form-control form-control-sm" id="father-name" name="father-name">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-phone" class="form-label">Father's Phone</label>
                <input required type="text" class="form-control form-control-sm" id="father-phone" name="father-phone">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-dob" class="form-label">Father's DOB</label>
                <input required type="date" class="form-control form-control-sm" id="father-dob" name="father-dob">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-name" class="form-label">Mother's Name</label>
                <input required type="text" class="form-control form-control-sm" id="mother-name" name="mother-name">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-phone" class="form-label">Mother's Phone</label>
                <input required type="text" class="form-control form-control-sm" id="mother-phone" name="mother-phone">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-dob" class="form-label">Mother's DOB</label>
                <input required type="date" class="form-control form-control-sm" id="mother-dob" name="mother-dob">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select " aria-label="Small select example"
                    required="" onchange="loadState(this)" required>
                    <option value="country">Country</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select " aria-label="Small select example" required=""
                    onchange="loadDistrict(this)" required>
                    <option value="state">state</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select " aria-label="Small select example"
                    required="" onchange="loadTehsil (this)" required>
                    <option value="dis">district</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select " aria-label="Small select example" required=""
                    required>
                    <option value="teh">teh</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Address</label>
                <input type="text" class="form-control form-control-sm" id="address" name="address" required>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input id="center" name="center" class="form-control  form-control-sm" required="">
                   
            </div>

        </div>
        <div class="text-center my-3"><button type="submit" class="btn btn-danger col-5">Submit</button>
        </div>
    </form>

</main>

<?php include '_footer.php'; ?>