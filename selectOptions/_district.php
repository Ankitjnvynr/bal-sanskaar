<option value="" selected>---District---</option>
<?php
require ("../config/_db.php");
if (isset($_GET['country']))
{
    $country = $_GET['country'];
    $state = $_GET['state'];
    $optionSql = "SELECT DISTINCT `district` FROM `allselect` WHERE country = '$country' AND state = '$state' ORDER BY district ASC";
    $result = $conn->query($optionSql);
    while ($row = mysqli_fetch_assoc($result))
    {
        if ($row['district'] != "")
        {
            echo '<option value="' . $row['district'] . '">' . $row['district'] . '</option>';
        }
    }
} else
{
    echo "country not selected";
}
?>