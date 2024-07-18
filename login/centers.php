<hr>
<p class="text-danger fs-7 fw-semibold">
    <?php
    $centerCountry = $_SESSION['country'];
    $centerState = $_SESSION['state'];
    $centerDist = $_SESSION['district'];
    $centerTeh = $_SESSION['tehsil'];

    if (isset($_POST['centerAdd']))
    {
        $newCenter = $_POST['newCenter'];
        $newCenter = htmlentities($newCenter);
        $centerSql = "INSERT INTO centers (country, state, district, tehsil, center)
                      VALUES ('$centerCountry', '$centerState', '$centerDist', '$centerTeh', '$newCenter')";
        try
        {
            if ($result = $conn->query($centerSql))
            {

            } else
            {
                echo $conn->error;
            }
        } catch (\Throwable $th)
        {
            echo $th->getMessage();
        }
    }
    ?>
</p>

<p>Available Centers</p>
<div class="d-flex flex-wrap py-2 gap-2">
    <?php
    $centersql = "SELECT id, center FROM centers WHERE country = '$centerCountry' AND state = '$centerState' AND district = '$centerDist' AND tehsil = '$centerTeh' ORDER BY center ASC";
    $res = $conn->query($centersql);

    $sr = 0;
    $centerNumbers = [];

    while ($row = $res->fetch_assoc())
    {
        if (preg_match('/\d+/', $row['center'], $matches))
        {
            $centerNumbers[] = (int) $matches[0];
        }
        ?>
        <div class="border border-danger bg-light shadow-sm p-2 px-3 rounded rounded-pill">
            <?php echo $row['center']; ?>
            <a href="del_center.php?id=<?php echo $row['id']; ?>">
                <button style="font-size:.8rem;" type="button" class="btn-close rounded rounded-pill bg-danger-subtle"
                    aria-label="Close"></button>
            </a>
        </div>
        <?php
    }

    if (!empty($centerNumbers))
    {
        $sr = max($centerNumbers) + 1;
    } else
    {
        $sr = 1;
    }
    ?>
    <div class="">
        <a style="text-decoration:none;"
            class="text-white border border-danger shadow-sm p-2 px-3 rounded rounded-pill btn btn-danger dropdown"
            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Add New
        </a>
        <ul class="dropdown-menu">
            <form action="" method="post">
                <li class="dropdown-item"><input name="newCenter" class="form-control" type="text"
                        value="Center-<?php echo $sr; ?>">
                </li>
                <li class="dropdown-item"><input class="btn btn-outline-danger ml-2 form-control" name="centerAdd"
                        type="submit" value="Add">
                </li>
            </form>
        </ul>
    </div>
</div>
