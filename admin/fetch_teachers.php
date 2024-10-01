<?php
include '../config/_db.php';

$country = $_POST['country'];
$state = $_POST['state'];
$tehsil = $_POST['tehsil'];
$district = $_POST['district'];

$whereClause = "WHERE country = '$country'";
if (!empty($state)) $whereClause .= " AND state = '$state'";
if (!empty($tehsil)) $whereClause .= " AND tehsil = '$tehsil'";
if (!empty($district)) $whereClause .= " AND district = '$district'";

$sql = "SELECT * FROM teachers $whereClause";
$result = $conn->query($sql);

$output = '<table class="table bg-warning-subtle">
            <thead>
                <tr>
                    <th>Teacher Type</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>DOB</th>
                    <th>Qualification</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Tehsil</th>
                    <th>Address</th>
                    <th>Center</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td>' . $row['teacher_type'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['phone'] . '</td>
                        <td>' . $row['dob'] . '</td>
                        <td>' . $row['qualification'] . '</td>
                        <td>' . $row['country'] . '</td>
                        <td>' . $row['state'] . '</td>
                        <td>' . $row['district'] . '</td>
                        <td>' . $row['tehsil'] . '</td>
                        <td>' . $row['address'] . '</td>
                        <td>' . $row['center'] . '</td>
                    </tr>';
    }
} else {
    $output .= '<tr><td colspan="11">No data found.</td></tr>';
}
$output .= '</tbody></table>';

echo $output;

$conn->close();
?>
