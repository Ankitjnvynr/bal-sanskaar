
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

        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
 <script src="../js/admin.js"></script>
    
</body>

</html>