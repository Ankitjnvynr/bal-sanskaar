<?php
include '_header.php';
include '../config/_db.php'; // include the database connection

ob_start(); // Start output buffering

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $dob = $_POST['dob'];
    $father_name = $_POST['father_name'];
    $father_phone = $_POST['father_phone'];
    $father_dob = $_POST['father_dob'];
    $mother_name = $_POST['mother_name'];
    $mother_phone = $_POST['mother_phone'];
    $mother_dob = $_POST['mother_dob'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $address = $_POST['address'];
    $center = isset($_POST['center']) ? $_POST['center'] : $_SESSION['userCenter'];
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Update student data
    $sql = "UPDATE students SET 
                rollno='$roll',
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
                address = '$address', 
                center = '$center' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE)
    {
        echo "<script type='text/javascript'> window.location.href = 'dashboard.php?data=student&page={$page}';</script>";
        exit;
    } else
    {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

// End output buffering and clean the buffer
ob_end_clean();

// Fetch student data for editing
if (isset($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        $student = $result->fetch_assoc();
    } else
    {
        echo "No record found";
        exit;
    }
} else
{
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

        <div class="text-center fw-bold my-2 text-danger fs-3">Edit Student Details</div>
        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Roll No</label>
                <input type="text" class="form-control form-control-sm" id="roll" name="roll"
                    value="<?php echo $student['rollno']; ?>" required>
            </div>
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
                <input class="form-control form-control-sm" type="text" id="countrySelect" name="country"
                    value="<?php echo $student['country']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="stateSelect" class="form-label">State</label>
                <input class="form-control form-control-sm" type="text" id="stateSelect" name="state"
                    value="<?php echo $student['state']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="districtSelect" class="form-label">District</label>
                <input class="form-control form-control-sm" type="text" id="districtSelect" name="district"
                    value="<?php echo $student['district']; ?>" />
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="tehsil" class="form-label">Tehsil</label>
                <input class="form-control form-control-sm" type="text" id="tehsil" name="tehsil"
                    value="<?php echo $student['tehsil']; ?>" />
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Address</label>
                <input type="text" class="form-control form-control-sm" id="address" name="address"
                    value="<?php echo $student['address']; ?>" required>
            </div>
            <div class="form-item bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <input type="text" id="center" name="center" autocomplete="off" value="<?php echo $student['center']; ?>"
                    class="form-control form-control-sm" >
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
        while ($row = $res->fetch_assoc())
        {
            echo "'" . $row['center'] . "',";
        }
        ?>
    ];
    // console.log(suggestions);
</script>

<?php include '_footer.php'; ?>
<?php $conn->close(); ?>