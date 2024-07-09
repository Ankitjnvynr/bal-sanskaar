<hr>
<p>Available Centers</p>
<div class="d-flex flex-wrap py-2 gap-2">
    <?php
    $centersql = "SELECT center FROM `centers`";
    $res = $conn->query($centersql);
    while ($row = $res->fetch_assoc())
    {
    ?>
    <div class="border border-danger bg-light shadow-sm p-2 px-3 rounded rounded-pill"><?php echo $row['center']; ?> <button style="font-size:.8rem;"
            type="button" class="btn-close rounded rounded-pill bg-danger-subtle" aria-label="Close"></button>
    </div>
    <?php
        }
    ?>
</div>
<div class="">
    <form class="d-flex" action="" method="post">
        <input name="newCenter" class="form-control" type="text">
        <input class="btn btn-outline-danger ml-2" type="submit" value="Add">
    </form>
</div>