
        <?php 
        $userName= $_SESSION['username'] ;
        $userPhone= $_SESSION['phone'];
        $userDistrict= $_SESSION['district'];
        $userTehsil= $_SESSION['tehsil'];
        $userType= $_SESSION['userType'];

         ?>
         <?php 
         
         ?>
        
        <ul class="nav flex-column">
           <div class="logo text-center ">
            <img width="80px" class='shadow rounded rounded-pill' src="../imgs/logo.png" alt="">
           </div>
            <li class="nav-item mt-3">
                <a class="nav-link" href="?data=student">All Student</a>
            </li>
            <?php 
            if($userType=='Head Teacher'){
            ?>
            <li class="nav-item">
                <a class="nav-link " href="?data=teacher">All Teacher</a>
            </li>
            <li>
                <div  class="  bg-warning-subtle rounded">
                    <!-- <div class="fs-7 text-danger text-center">select a teacher</div> -->
                    <!-- Search bar -->
                <div id="searchBar">
                <input type="text" class="form-control " id="searchInput" placeholder="Search... by name">
                </div>
                <ul id="itemList" style="height:50vh" class="list-group bg-warning-subtle fs-7 overflow-y-scroll" >
                    <?php 
                    $sql = "SELECT * FROM teachers WHERE `district` = '$userDistrict' AND `tehsil` = '$userTehsil'";
                    $result = $conn->query($sql);
            
                    if ($numrow = $result->num_rows > 0)
                    {
                     
                      $sr=0;
                      while ($row = $result->fetch_assoc())
                      {
                        $name = mb_convert_case($row['name'], MB_CASE_TITLE, "UTF-8");
                        $center = mb_convert_case($row['center'], MB_CASE_TITLE, "UTF-8");
                        echo "<li class='list-group-item bg-warning-subtle' ><a class='text-black fs-7 m-0 p-0' href='?data=filterStudent&center={$row['center']}'>{$name}<span style='font-size:0.8rem;' class='fw-semibold fs-7 text-muted'>({$center})</span></a></li>";
                      }
                    }
                    ?>
                    
                </ul>
                </div>
            </li>
            <?php 
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
