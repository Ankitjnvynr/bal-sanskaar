<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}

include '../config/_db.php';

// Function to filter and generate the report
function filterAndGenerateReport($conn, $filter_data = [], $format = 'csv') {
    $query = "SELECT * FROM teachers WHERE 1=1";

    // Apply filters based on passed data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filter_data = [
            'teacher_type' => $_POST['teacher_type'] ?? '',
            'name' => $_POST['name'] ?? '',
            'dob' => $_POST['dob'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'qualification' => $_POST['qualification'] ?? '',
            'country' => $_POST['country'] ?? '',
            'state' => $_POST['state'] ?? '',
            'district' => $_POST['district'] ?? '',
            'tehsil' => $_POST['tehsil'] ?? '',
            'address' => $_POST['address'] ?? '',
            'center' => $_POST['center'] ?? '',
            'dt' => $_POST['dt'] ?? ''
        ];
    
        $query = "SELECT * FROM teachers WHERE 1=1";
    
        // Apply filters based on passed data
        if (!empty($filter_data['teacher_type'])) {
            $query .= " AND teacher_type = '" . $conn->real_escape_string($filter_data['teacher_type']) . "'";
        }
        if (!empty($filter_data['name'])) {
            $query .= " AND name LIKE '%" . $conn->real_escape_string($filter_data['name']) . "%'";
        }
        if (!empty($filter_data['dob'])) {
            $query .= " AND dob = '" . $conn->real_escape_string($filter_data['dob']) . "'";
        }
        if (!empty($filter_data['phone'])) {
            $query .= " AND phone = '" . $conn->real_escape_string($filter_data['phone']) . "'";
        }
        if (!empty($filter_data['qualification'])) {
            $query .= " AND qualification = '" . $conn->real_escape_string($filter_data['qualification']) . "'";
        }
        if (!empty($filter_data['country'])) {
            $query .= " AND country = '" . $conn->real_escape_string($filter_data['country']) . "'";
        }
        if (!empty($filter_data['state'])) {
            $query .= " AND state = '" . $conn->real_escape_string($filter_data['state']) . "'";
        }
        if (!empty($filter_data['district'])) {
            $query .= " AND district = '" . $conn->real_escape_string($filter_data['district']) . "'";
        }
        if (!empty($filter_data['tehsil'])) {
            $query .= " AND tehsil = '" . $conn->real_escape_string($filter_data['tehsil']) . "'";
        }
        if (!empty($filter_data['address'])) {
            $query .= " AND address LIKE '%" . $conn->real_escape_string($filter_data['address']) . "%'";
        }
        if (!empty($filter_data['center'])) {
            $query .= " AND center = '" . $conn->real_escape_string($filter_data['center']) . "'";
        }
        if (!empty($filter_data['dt'])) {
            $query .= " AND dt = '" . $conn->real_escape_string($filter_data['dt']) . "'";
        }
    
        $result = $conn->query($query);
    
        if ($format == 'csv') {
            generateCSV($result);
        } else {
            generateHTMLPDF($result);
        }
    }
}

// Generate CSV file
function generateCSV($result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="teacher_report.csv"');
    $output = fopen('php://output', 'w');

    // Set table headers
    fputcsv($output, ['sr', 'Teacher Type', 'Name', 'DOB', 'Phone', 'Qualification', 'Country', 'State', 'District', 'Tehsil', 'Address', 'Center', 'Start Date']);


    // Add data from the result
    $sr=0;
    while ($data = $result->fetch_assoc()) {
        $sr++;
        $startDate = date('Y-m-d', strtotime($data['dt'])); // Convert dt to start date format
        fputcsv($output, [
            $sr,
            $data['teacher_type'],
            $data['name'],
            $data['dob'],
            $data['phone'],
            $data['qualification'],
            $data['country'],
            $data['state'],
            $data['district'],
            $data['tehsil'],
            $data['address'],
            $data['center'],
            $startDate
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

// Handle form submission from filter_form.php
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
