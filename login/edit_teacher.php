<?php
include '_header.php';
include '../config/_db.php'; // include the database connection

// Fetch existing data for the teacher
if (isset($_GET['id']))
{
    $teacherId = $_GET['id'];
    $sql = "SELECT * FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1)
    {
        $teacher = $result->fetch_assoc();
    } else
    {
        $_SESSION['message'] = "Teacher not found";
        header("Location: index.php");
        exit();
    }
    $stmt->close();
} else
{
    $_SESSION['message'] = "Invalid request";
    header("Location: index.php");
    exit();
}
?>

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
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

    <form action="update_teacher.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Edit Teacher Details</div>

        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">

            <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
            <input type="hidden" name="page" value="<?php echo isset($_GET['page'])?$_GET['page']:1; ?>">


            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name"
                    value="<?php echo $teacher['name']; ?>" required>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob"
                    value="<?php echo $teacher['dob']; ?>" required>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                    value="<?php echo $teacher['phone']; ?>" onkeypress="return onlyDigits(event)" size="10"
                    minlength="10" maxlength="10" required>
                <div id="phone-error" class="text-danger"></div>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <input disabled id="countrySelect" name="country" class="form-select " value="<?php echo $_SESSION['country']; ?>" />

            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <input disabled id="stateSelect" name="state" class="form-select "
                    value="<?php echo $_SESSION['state']; ?>" />
            </div>

            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="district" class="form-label">District</label>
                <input disabled id="districtSelect" name="district" class="form-select "
                    value="<?php echo $_SESSION['district']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>

                <input disabled id="tehsil" name="tehsil" class="form-select "
                    value="<?php echo $_SESSION['tehsil']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0 position-relative">
                <label for="center" class="form-label">Center</label>
                <input type="text" id="center" name="center" autocomplete="off" class="form-control form-control-sm"
                    value="<?php echo $teacher['center']; ?>" required>
                <div id="centerSuggestions" class="suggestions"></div>
            </div>

        </div>
        <div class="text-center my-3"><button type="submit" class="btn btn-danger col-5">Update</button></div>
    </form>

    <?php
    include 'centers.php';
    ?>

</main>
<script>
    const suggestions = [
        <?php
        $centersql = "SELECT id, center FROM `centers` WHERE country = '{$teacher['country']}' AND state = '{$teacher['state']}' AND district = '{$teacher['district']}' AND tehsil = '{$teacher['tehsil']}' ORDER BY center ASC";
        $res = $conn->query($centersql);
        while ($row = $res->fetch_assoc())
        {
            echo "'" . $row['center'] . "',";
        }
        ?>
    ];

    document.getElementById('center').addEventListener('input', function () {
        const input = this.value.toLowerCase();
        const suggestionsBox = document.getElementById('centerSuggestions');
        suggestionsBox.innerHTML = '';

        if (input) {
            const filteredSuggestions = suggestions.filter(suggestion =>
                suggestion.toLowerCase().includes(input)
            );

            filteredSuggestions.forEach(suggestion => {
                const div = document.createElement('div');
                div.className = 'suggestion';
                div.textContent = suggestion;
                div.addEventListener('click', function () {
                    document.getElementById('center').value = this.textContent;
                    suggestionsBox.innerHTML = '';
                });
                suggestionsBox.appendChild(div);
            });
        }
    });

    function loadState(countrySelect) {
        // Implement AJAX to load states based on selected country
    }

    function loadDistrict(stateSelect) {
        // Implement AJAX to load districts based on selected state
    }

    function loadTehsil(districtSelect) {
        // Implement AJAX to load tehsils based on selected district
    }

    function onlyDigits(event) {
        const charCode = event.which ? event.which : event.keyCode;
        if (charCode < 48 || charCode > 57) {
            event.preventDefault();
        }
    }
</script>
<?php include '_footer.php'; ?>