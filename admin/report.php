<?php include '_header.php'; ?>
<?php

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}

include '../config/_db.php';

?>
<?php

// Function to filter and generate the report
function filterAndGenerateReport($conn, $filter_data = [], $format = 'csv') {
    $query = "SELECT * FROM teachers WHERE 1=1";

    // Apply filters based on passed data
    if (!empty($filter_data['teacher_type'])) {
        $query .= " AND teacher_type = '" . $conn->real_escape_string($filter_data['teacher_type']) . "'";
    }
    if (!empty($filter_data['name'])) {
        $query .= " AND name LIKE '%" . $conn->real_escape_string($filter_data['name']) . "%'";
    }
    // Add more filters (dob, phone, country, state, etc.)

    $result = $conn->query($query);

    if ($format == 'csv') {
        generateCSV($result);
    } else {
        generateHTMLPDF($result);
    }
}

// Generate CSV file
function generateCSV($result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="teacher_report.csv"');
    $output = fopen('php://output', 'w');

    // Set table headers
    fputcsv($output, ['ID', 'Teacher Type', 'Name', 'DOB', 'Phone']);

    // Add data from the result
    while ($data = $result->fetch_assoc()) {
        fputcsv($output, [
            $data['id'],
            $data['teacher_type'],
            $data['name'],
            $data['dob'],
            $data['phone']
        ]);
    }

    fclose($output);
    exit();
}

// Generate HTML (Simulated PDF)
function generateHTMLPDF($result) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment;filename="teacher_report.pdf"');

    echo "<html><body>";
    echo "<h1>Teacher Report</h1>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>ID</th>
            <th>Teacher Type</th>
            <th>Name</th>
            <th>DOB</th>
            <th>Phone</th>
        </tr>";

    // Add data from the result
    while ($data = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$data['id']}</td>
                <td>{$data['teacher_type']}</td>
                <td>{$data['name']}</td>
                <td>{$data['dob']}</td>
                <td>{$data['phone']}</td>
            </tr>";
    }

    echo "</table>";
    echo "</body></html>";
    exit();
}

// Handle form submission for filter and report generation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_data = [
        'teacher_type' => $_POST['teacher_type'] ?? '',
        'name' => $_POST['name'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'country' => $_POST['country'] ?? '',
        'state' => $_POST['state'] ?? '',
        // Add more fields as necessary
    ];
    
    $format = $_POST['format']; // 'csv' or 'pdf'
    filterAndGenerateReport($conn, $filter_data, $format);
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center  rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>

  <div style="min-height:60vh; max-width:500px;" class="d-flex flex-column justify-content-center align-items-center gap-3 m-auto ">
  <h1>Filter Teacher Report</h1> 
    <form class="d-flex mb-4" method="POST" action="generate_report.php">
        <div class="form-container  ">
            <div class="form-group">
                <select id="countrySelect" onchange="loadState(this)" name="country"></select>
            </div>
            <div class="form-group">
                <select id="stateSelect" onchange="loadDistrict(this)" name="state"></select>
            </div>
            <div class="form-group">
                <select id="districtSelect" onchange="loadTehsil(this)" name="district"></select>
            </div>
            <div class="form-group">
                <select id="tehsil" name="tehsil"></select>
            </div>
            <div class="form-group">
                <input type="text" class="filter-input" id="name" name="name" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="tel" class="filter-input" id="phone" name="phone" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <select name="teacher_type" id="teacher_type">
                    <option value="">Select Teacher Type</option>
                    <?php
                $arr = ['City Head', 'State Head', 'Teacher', 'Teacher1'];
                foreach ($arr as $item) {
                    echo '<option value="' . $item . '">' . $item . '</option>';
                }
                ?>
                </select>
            </div>
            <div class="form-group">
               
                <select name="format" id="format">
                    <option value="csv">CSV (Excel)</option>
                    <!-- <option value="pdf">HTML (Simulated PDF)</option> -->
                </select>
            </div>
            <div class="form-group border d-flex justify-content-center align-items-center">
                <input type="hidden" name="data" value="teacher">
                <button class="btn btn-success p-0 px-1 flex-1 w-full  " type="submit">Generate Report</button>
            </div>
        </div>
    </form>
  </div>




    
</main>
<?php include '_footer.php'; ?>