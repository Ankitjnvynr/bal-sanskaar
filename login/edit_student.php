<?php
include '_header.php';
include '../config/_db.php'; // include the database connection

ob_start(); // Start output buffering

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $father_name = $_POST['father_name'];
    $father_phone = $_POST['father_phone'];
    $father_dob = $_POST['father_dob'];
    $mother_name = $_POST['mother_name'];
    $mother_phone = $_POST['mother_phone'];
    $mother_dob = $_POST['mother_dob'];
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $state = isset($_POST['state']) ? $_POST['state'] : $_SESSION['state'];
    $district = isset($_POST['district']) ? $_POST['district'] : $_SESSION['district'];
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : $_SESSION['tehsil'];
    $center = isset($_POST['center']) ? $_POST['center'] : $_SESSION['userCenter'];
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Update student data
    $sql = "UPDATE students SET 
                name = '$name', 
                dob = '$dob', 
                father_name = '$father_name', 
                father_phone = '$father_phone', 
                father_dob = '$father_dob', 
                mother_name = '$mother_name', 
                mother_phone = '$mother_phone', 
                mother_dob = '$mother_dob', 
                country = '$country', 
                state = '$state', 
                district = '$district', 
                tehsil = '$tehsil', 
                center = '$center' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'> window.location.href = 'dashboard.php?data=student&page={$page}';</script>";
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

// End output buffering and clean the buffer
ob_end_clean();

// Fetch student data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit;
    }
} else {
    echo "Invalid request";
    exit;
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
    max-width: 300px;
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

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        <input type="hidden" name="center" value="<?php echo $student['center']; ?>">

        <div class="text-center fw-bold my-2 text-danger fs-3">Edit Student Details</div>
        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name"
                    value="<?php echo $student['name']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob"
                    value="<?php echo $student['dob']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father_name" class="form-label">Father's Name</label>
                <input type="text" class="form-control form-control-sm" id="father_name" name="father_name"
                    value="<?php echo $student['father_name']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father_phone" class="form-label">Father's Phone</label>
                <input type="text" class="form-control form-control-sm" id="father_phone" name="father_phone"
                    value="<?php echo $student['father_phone']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father_dob" class="form-label">Father's DOB</label>
                <input type="date" class="form-control form-control-sm" id="father_dob" name="father_dob"
                    value="<?php echo $student['father_dob']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother_name" class="form-label">Mother's Name</label>
                <input type="text" class="form-control form-control-sm" id="mother_name" name="mother_name"
                    value="<?php echo $student['mother_name']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother_phone" class="form-label">Mother's Phone</label>
                <input type="text" class="form-control form-control-sm" id="mother_phone" name="mother_phone"
                    value="<?php echo $student['mother_phone']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother_dob" class="form-label">Mother's DOB</label>
                <input type="date" class="form-control form-control-sm" id="mother_dob" name="mother_dob"
                    value="<?php echo $student['mother_dob']; ?>">
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <input disabled id="countrySelect" name="country" class="form-select "
                    value="<?php echo $_SESSION['country']; ?>" />
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
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input type="text" id="center" name="center" <?php if ($_SESSION['userType'] == 'Teacher') {
                                        echo "value='{$_SESSION['userCenter']}' disabled ";
                                    } ?> value="<?php echo $student['center']; ?>"
                    class="form-control form-control-sm">
                <div id="centerSuggestions" class="suggestions"></div>
            </div>
        </div>
        <div class="text-center my-3">
            <button type="submit" class="btn btn-danger col-5">Update</button>
        </div>
    </form>
</main>

<script>
const suggestions = [
    <?php
        $centerCountry = $student['country'];
        $centerState = $student['state'];
        $centerDist = $student['district'];
        $centerTeh = $student['tehsil'];
        $centersql = "SELECT id, center FROM `centers` WHERE country = '$centerCountry' AND state = '$centerState' AND district = '$centerDist' AND tehsil = '$centerTeh' ORDER BY center ASC";
        $res = $conn->query($centersql);
        while ($row = $res->fetch_assoc()) {
            echo "'" . $row['center'] . "',";
        }
        ?>
];
console.log(suggestions);

function handleClick() {
    const centerInput = document.getElementById('center');
}
</script>

<?php include '_footer.php'; ?>
<?php $conn->close(); ?>