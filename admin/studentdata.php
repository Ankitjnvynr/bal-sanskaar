<?php
// Pagination logic
$limit = 10; // Number of entries to show in a page.
if (isset($_GET["page"]))
{
    $page = $_GET["page"];
} else
{
    $page = 1;
}
;
$start_from = ($page - 1) * $limit;

// Search logic
$search_query = "";
if (isset($_GET['search']))
{
    $search_query = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR father_name LIKE '%$search_query%' OR mother_name LIKE '%$search_query%' LIMIT $start_from, $limit";
} else
{
    $sql = "SELECT * FROM students LIMIT $start_from, $limit";
}
$result = $conn->query($sql);

?>
<h4>Students Table</h4>
<form class="d-flex mb-4" method="GET" action="dashboard.php?data=student">
    <input type="hidden" name="data" value="student">
    <input class="form-control me-2" type="search" name="search" placeholder="Search"
        value="<?php echo htmlspecialchars($search_query); ?>" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>
<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>DOB</th>
            <th>Father's Name</th>
            <th>Father's Phone</th>
            <th>Father's DOB</th>
            <th>Mother's Name</th>
            <th>Mother's Phone</th>
            <th>Mother's DOB</th>
            <th>Country</th>
            <th>State</th>
            <th>District</th>
            <th>Tehsil</th>
            <th>Center</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['dob']}</td>
                            <td>{$row['father_name']}</td>
                            <td>{$row['father_phone']}</td>
                            <td>{$row['father_dob']}</td>
                            <td>{$row['mother_name']}</td>
                            <td>{$row['mother_phone']}</td>
                            <td>{$row['mother_dob']}</td>
                            <td>{$row['country']}</td>
                            <td>{$row['state']}</td>
                            <td>{$row['district']}</td>
                            <td>{$row['tehsil']}</td>
                            <td>{$row['center']}</td>
                        </tr>";
            }
        } else
        {
            echo "<tr><td colspan='14'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Pagination for search results
if (isset($_GET['search']))
{
    $sql = "SELECT COUNT(id) FROM students WHERE name LIKE '%$search_query%' OR father_name LIKE '%$search_query%' OR mother_name LIKE '%$search_query%'";
} else
{
    $sql = "SELECT COUNT(id) FROM students";
}
$result = $conn->query($sql);
$row = $result->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);

$pagLink = "<nav><ul class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++)
{
    if (isset($_GET['search']))
    {
        $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=" . $i . "&search=" . $search_query . "'>" . $i . "</a></li>";
    } else
    {
        $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=" . $i . "'>" . $i . "</a></li>";
    }
}
echo $pagLink . "</ul></nav>";

?>