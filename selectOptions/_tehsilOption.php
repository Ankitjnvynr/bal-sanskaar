<option value="" selected>---Tehsil---</option>
<?php
require ("../config/_db.php");
if (isset($_GET['country']))
{
    $country = $_GET['country'];
    $state = $_GET['state'];
    $district = $_GET['district'];
    $optionSql = "SELECT DISTINCT `tehsil` FROM `allselect`  WHERE country = '$country' AND state = '$state' AND district = '$district' ORDER BY tehsil ASC";
    $result = $conn->query($optionSql);
    while ($row = mysqli_fetch_assoc($result))
    {
        if ($row['tehsil'] != "")
        {
            echo '<option value="' . $row['tehsil'] . '">' . $row['tehsil'] . '</option>';
        }
    }
} else
{
    echo "country not selected";
}
?>