<?php
require_once '../config/_db.php';
// SQL query to fetch data
$sql = "SELECT id, title, subtitle, file_name, dt FROM syllabus";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row as cards
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="card p-2 text-center position-relative">
            <button onclick="deleteRecord(' . $row["id"] . ')" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">Delete</button>
            <img class="m-auto" width="150px" src="../imgs/sylabus icon.png" alt="">
            <h6>' . htmlspecialchars($row["title"]) . '</h6>
            <p class="text-muted fs-6">' . htmlspecialchars($row["subtitle"]) . '</p>
            <span>
                <a href="../imgs/syllabus/' . urlencode($row["file_name"]) . '" class="btn btn-outline-success mx-1 btn-sm">View</a>
                <a href="../imgs/syllabus/' . urlencode($row["file_name"]) . '" class="btn btn-success mx-1 btn-sm " download>Download</a>

            </span>
        </div>
        ';
    }
} else {
    echo "No records found.";
}

// Close the connection
$conn->close();
?>
