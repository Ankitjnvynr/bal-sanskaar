<?php
include '../config/_db.php';

$country = $_POST['country'];
$state = $_POST['state'];
$tehsil = $_POST['tehsil'];
$district = $_POST['district'];
$center = $_POST['center'];

// Fetch Teachers
$teachersSql = "SELECT * FROM teachers WHERE country = '$country' AND center = '$center'";
if (!empty($state)) $teachersSql .= " AND state = '$state'";
if (!empty($tehsil)) $teachersSql .= " AND tehsil = '$tehsil'";
if (!empty($district)) $teachersSql .= " AND district = '$district'";

$teachersResult = $conn->query($teachersSql);

// Prepare output
$output = '<table class="table bg-warning-subtle">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>DOB</th>                                 
                    <th>Qualification</th>                                 
                    <th>Country</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Tehsil</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>';

// Add Teachers to Output
if ($teachersResult->num_rows > 0) {
    while ($row = $teachersResult->fetch_assoc()) {
        $output .= '<tr>
        <td>Teacher</td>
        <td>' . htmlspecialchars($row['name']) . '</td>
        <td>' . htmlspecialchars($row['phone']) . '</td>
        <td>' . htmlspecialchars($row['dob']) . '</td>
        <td>' . htmlspecialchars($row['qualification']) . '</td>
        <td>' . htmlspecialchars($row['country']) . '</td>
        <td>' . htmlspecialchars($row['state']) . '</td>
        <td>' . htmlspecialchars($row['district']) . '</td>
        <td>' . htmlspecialchars($row['tehsil']) . '</td>
        <td>' . htmlspecialchars($row['address']) . '</td>
       
    </tr>';

    }
}

// If no teachers found
if ($teachersResult->num_rows == 0) {
    $output .= '<tr><td colspan="10">No data found.</td></tr>';
}

$output .= '</tbody></table>';

echo $output;

$conn->close();
?>
