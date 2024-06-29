<table class="table my-2">
    <thead>
        <tr>
            <th scope="col">Sr</th>
            <th scope="col">Tehsils</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php
        require ("../config/_db.php");
        if (isset($_GET['country']))
        {
            $country = $_GET['country'];
            $state = $_GET['state'];
            $district = $_GET['district'];
            $optionSql = "SELECT DISTINCT `tehsil` , `id` FROM `allselect`  WHERE country = '$country' AND state = '$state' AND district = '$district' ORDER BY tehsil ASC";
            $result = $conn->query($optionSql);
            $sr = 0;
            while ($row = mysqli_fetch_assoc($result))
            {
                if ($row['tehsil'] != "")
                {
                    $sr++;
                    echo '
                    <tr>
                        <th scope="row">'.$sr.'</th>
                        <td>'. $row['tehsil'].'</td>
                        <td class="dels fw-bold " onclick="deleting(' . $row['id'] . ')" id="del' . $row['id'] . '"><span data-bs-toggle="modal" data-bs-target="#deletemodal" class = "btn text-danger"> Delete</span></td>
                    </tr>
                    ';
                }
            }
        } else
        {
            echo "country not selected";
        }
        ?>
    </tbody>
</table>