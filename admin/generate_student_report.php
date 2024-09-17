<?php
// Database connection
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}

include '../config/_db.php';

// Function to filter and generate the report
function filterAndGenerateReport($conn, $filter_data = [], $format = 'csv') {
    $query = "SELECT * FROM students WHERE 1=1";

    // Apply filters based on passed data
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
    if (!empty($filter_data['center'])) {
        $query .= " AND center = '" . $conn->real_escape_string($filter_data['center']) . "'";
    }

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
    header('Content-Disposition: attachment;filename="student_report.csv"');
    $output = fopen('php://output', 'w');

    // Set table headers
    fputcsv($output, ['ID', 'Roll No', 'Name', 'DOB', 'Father\'s Name', 'Father\'s Phone',  'Mother\'s Name', 'Mother\'s Phone', 'Country', 'State', 'District', 'Tehsil', 'Address', 'Center']);

    // Add data from the result
    while ($data = $result->fetch_assoc()) {
        fputcsv($output, [
            $data['id'],
            $data['rollno'],
            $data['name'],
            $data['dob'],
            $data['father_name'],
            $data['father_phone'],
           
            $data['mother_name'],
            $data['mother_phone'],
       
            $data['country'],
            $data['state'],
            $data['district'],
            $data['tehsil'],
            $data['address'],
            $data['center']
        ]);
    }

    fclose($output);
    exit();
}

// Generate HTML (Simulated PDF)
function generateHTMLPDF($result) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment;filename="student_report.pdf"');

    echo "<html><body>";
    echo "<h1>Student Report</h1>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
        <th>ID</th>
        <th>Roll No</th>
        <th>Name</th>
        <th>DOB</th>
        <th>Father's Name</th>
        <th>Father's Phone</th>
        <th>Father's DOB</th>
        <th>Mother's Name</th>
        <th>Mother's Phone</th>
        <th>Mother's DOB</th>
        <th>Country</th>
        <th>State</th>
        <th>District</th>
        <th>Tehsil</th>
        <th>Address</th>
        <th>Center</th>
    </tr>";

    // Add data from the result
    while ($data = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$data['id']}</td>
            <td>{$data['rollno']}</td>
            <td>{$data['name']}</td>
            <td>{$data['dob']}</td>
            <td>{$data['father_name']}</td>
            <td>{$data['father_phone']}</td>
            <td>{$data['father_dob']}</td>
            <td>{$data['mother_name']}</td>
            <td>{$data['mother_phone']}</td>
            <td>{$data['mother_dob']}</td>
            <td>{$data['country']}</td>
            <td>{$data['state']}</td>
            <td>{$data['district']}</td>
            <td>{$data['tehsil']}</td>
            <td>{$data['address']}</td>
            <td>{$data['center']}</td>
        </tr>";
    }

    echo "</table>";
    echo "</body></html>";
    exit();
}

// Handle form submission from generate_student_report.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_data = [
        'country' => $_POST['country'] ?? '',
        'state' => $_POST['state'] ?? '',
        'district' => $_POST['district'] ?? '',
        'tehsil' => $_POST['tehsil'] ?? '',
        'center' => $_POST['center'] ?? ''
    ];

    $format = $_POST['format']; // 'csv' or 'pdf'
    filterAndGenerateReport($conn, $filter_data, $format);
}
?>