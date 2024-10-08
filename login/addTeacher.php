<?php include '_header.php'; ?>
<style>
.suggestions {
    position: absolute;
    border: 1px solid #ccc;
    border-top: none;
    z-index: 1000;
    width: 95%;
    max-height: 150px;
    overflow-y: auto;
    border-radius: 0 0 0.25rem 0.25rem;
    background-color: white;
}

.suggestion {
    padding: 10px;
    cursor: pointer;
}

.suggestion:hover {
    background-color: #f0f0f0;
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none"></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="../parts/teacher_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Teacher Details</div>

        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="type" class="form-label">Teacher/City Head</label>
                <select id="type" name="type" class="form-select" required>
                    <?php
                    $arr = ['Teacher', 'Teacher 1'];
                    foreach ($arr as $value) {
                        if ($value == $_GET['type']) {
                            echo '<option selected value="' . $value . '">' . $value . '</option>';
                        } else {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
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
                <input disabled id="countrySelect" name="country" class="form-select"
                    value="<?php echo $_SESSION['country']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="stateSelect" class="form-label">State</label>
                <input disabled id="stateSelect" name="state" class="form-select"
                    value="<?php echo $_SESSION['state']; ?>" />
            </div>

            <?php
            if ($_SESSION['userType'] == 'State Head') {
            ?>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="districtSelect" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select" aria-label="Small select example"
                    required onchange="loadTehsil(this)">
                    <option value="dis">district</option>
                </select>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select" aria-label="Small select example" required>
                </select>
            </div>
            <?php
            } else {
            ?>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="districtSelect" class="form-label">District</label>
                <input disabled id="districtSelect" name="district" class="form-select"
                    value="<?php echo $_SESSION['district']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <input disabled id="tehsil" name="tehsil" class="form-select"
                    value="<?php echo $_SESSION['tehsil']; ?>" />
            </div>
            <?php
            }
            ?>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control form-control-sm" rows="2"></textarea>
            </div>

        </div>
        <div class="text-center my-3"><button type="submit" class="btn btn-danger col-5">Submit</button></div>
    </form>
</main>

<?php include '_footer.php'; ?>

<script>
loadDistrict({
    value: "<?php echo $_SESSION['state'] ?>"
})
</script>