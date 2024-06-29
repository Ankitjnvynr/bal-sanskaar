<option value="" selected>---State---</option>
<?php
require ("../config/_db.php");
if (isset($_GET['country']))
{
    $country = $_GET['country'];
    $optionSql = "SELECT DISTINCT `state` FROM `allselect` WHERE country = '$country' ORDER BY state ASC";
    $result = $conn->query($optionSql);
    while ($row = mysqli_fetch_assoc($result))
    {
        if ($row['state'] != "")
        {
            echo '<option value="' . $row['state'] . '">' . $row['state'] . '</option>';
        }
    }
} else
{
    echo "country not selected";
}
?>