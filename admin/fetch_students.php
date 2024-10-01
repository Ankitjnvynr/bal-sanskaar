<?php
include '../config/_db.php';

$country = $_POST['country'];
$state = $_POST['state'];
$tehsil = $_POST['tehsil'];
$district = $_POST['district'];

$whereClause = "WHERE country = '$country' AND center = '{$_POST['center']}'";
if (!empty($state)) $whereClause .= " AND state = '$state'";
if (!empty($tehsil)) $whereClause .= " AND tehsil = '$tehsil'";
if (!empty($district)) $whereClause .= " AND district = '$district'";

$sql = "SELECT * FROM students $whereClause";
$result = $conn->query($sql);

$output = '<table class="table">
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Father Name</th>
                    <th>Father Phone</th>
                    <th>Mother Name</th>
                    <th>Mother Phone</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Tehsil</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td>' . $row['rollno'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['dob'] . '</td>
                        <td>' . $row['father_name'] . '</td>
                        <td>' . $row['father_phone'] . '</td>
                        <td>' . $row['mother_name'] . '</td>
                        <td>' . $row['mother_phone'] . '</td>
                        <td>' . $row['country'] . '</td>
                        <td>' . $row['state'] . '</td>
                        <td>' . $row['district'] . '</td>
                        <td>' . $row['tehsil'] . '</td>
                        <td>' . $row['address'] . '</td>
                    </tr>';
    }
} else {
    $output .= '<tr><td colspan="12">No data found.</td></tr>';
}
$output .= '</tbody></table>';

echo $output;

$conn->close();
?>
