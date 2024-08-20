<?php include '_header.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center  rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="../parts/teacher_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Teacher Details</div>

        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="type" class="form-label">Teacher/City Head</label>
                <select id="type" name="type" class="form-select" required>
                    <?php
                    $arr = ['City Head', 'Teacher','State Head'];
                    foreach ($arr as $value)
                    {
                        if ($value == $_GET['type'])
                        {
                            echo '<option selected value="' . $value . '">' . $value . '</option>';
                        } else
                        {
                            echo '<option  value="' . $value . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name">
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob">
            </div>

            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                    onkeypress="return onlyDigits(event)" size="10" minlength="10" maxlength="10">
                <div id="phone-error" class="text-danger"></div>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Qualification</label>
                <input type="text" class="form-control form-control-sm" id="qualification" name="qualification"
                    >
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
                <select id="tehsil" name="tehsil" class="form-select " aria-label="Small select example" required>
                    <option value="teh">teh</option>
                </select>
            </div>
            <!-- <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input type="text" id="center" name="center" class="form-control form-control-sm">
            </div> -->

        </div>
        <div class="text-center my-3"><button type="submit" class="btn btn-danger col-5">Submit</button></div>
    </form>

</main>

<?php include '_footer.php'; ?>