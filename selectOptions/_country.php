<?php
require ("../config/_db.php");
$optionSql = "SELECT DISTINCT `country` FROM `allselect`";
$result = $conn->query($optionSql);

if (!$result) {
    // Error handling: Display or log the error message
    echo "Error: " . $conn->error;
} else {
    // If the query was successful
    while ($row = mysqli_fetch_assoc($result)) {
        if($row['country']=='India'){
            echo '<option selected value="' . $row['country'] . '">' . $row['country'] . '</option>';
        }else{
            echo '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';
        }
    }
    // Free the result set
    mysqli_free_result($result);
}
?>
