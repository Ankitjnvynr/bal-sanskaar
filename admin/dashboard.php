<?php include '_header.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
                
                <div
                    class="h4 text-center shadow-sm my-1 p-1 align-items-center  rounded-2 text-danger d-flex justify-content-between">
                    <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas"
                        class="fa-solid fa-bars d-md-none "></i>
                    Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
                </div>

                <?php
                if ($_GET['data'] == 'student')
                {
                    include 'studentdata.php';
                } else
                {
                    include 'teacherdata.php';
                }
                ?>

            </main>

<?php include '_footer.php'; ?>