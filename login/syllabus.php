<?php include '_header.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none"></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE); ?>
    </div>

   
    <div class="my-1">
        <h5>All Syllabus</h5>
        <div id="allDocuments" class="d-flex flex-wrap my-2 gap-2"></div>
    </div>
</main>

<?php include '_footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>





$(document).ready(function() {
   
    $('#allDocuments').load('allSyllabusLoad.php');

   
});
</script>