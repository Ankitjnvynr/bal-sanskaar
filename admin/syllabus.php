<?php include '_header.php'; ?>

<style>
    #drop-area {
        border: 2px dashed #6c757d;
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
        cursor: pointer;
    }

    #drop-area.dragover {
        background-color: #e9ecef;
        border-color: #007bff;
    }

    #uploadStatus {
        display: none;
    }

    .alert {
        margin-top: 20px;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none "></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE) ?>
    </div>




    <form id="uploadForm" class="shadow-lg p-4 rounded bg-light">
        <!-- Title and Description Input -->
        <div class="mb-3">
            <label for="title" class="form-label">PDF Title</label>
            <input type="text" class="form-control" id="title" placeholder="Enter PDF title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">PDF Description</label>
            <textarea class="form-control" id="description" rows="3" placeholder="Enter PDF description" required></textarea>
        </div>

        <!-- Drag-and-Drop Area -->
        <div id="drop-area" class="border border-dashed p-5 text-center mb-3" style="border-radius: 10px;">
            <p class="lead">Drag & Drop PDF here</p>
            <p>or</p>
            <input type="file" id="fileInput" accept="application/pdf" class="form-control" hidden>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click();">Browse File</button>
        </div>

        <!-- Upload Status -->
        <div id="uploadStatus" class="mt-3"></div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success w-100">Upload PDF</button>
    </form>

</main>

<?php include '_footer.php'; ?>
<script>
    $(document).ready(function() {
        const dropArea = $('#drop-area');
        const fileInput = $('#fileInput');
        const uploadForm = $('#uploadForm');
        const uploadStatus = $('#uploadStatus');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.on(eventName, preventDefaults);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.on(eventName, () => dropArea.addClass('dragover'));
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.on(eventName, () => dropArea.removeClass('dragover'));
        });

        // Handle dropped files
        dropArea.on('drop', handleDrop);

        function handleDrop(e) {
            const dt = e.originalEvent.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            fileInput[0].files = files; // Populate hidden input with dropped file
        }

        // Handle form submission with jQuery AJAX
        uploadForm.on('submit', function(e) {
            e.preventDefault();

            const title = $('#title').val();
            const description = $('#description').val();
            const file = fileInput[0].files[0];

            if (!file) {
                alert('Please upload a PDF file');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('file', file);

            $.ajax({
                url: 'upload.php', // Replace with your server-side upload script URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    uploadStatus.html('<div class="alert alert-success">File uploaded successfully!</div>').fadeIn();
                },
                error: function() {
                    uploadStatus.html('<div class="alert alert-danger">File upload failed.</div>').fadeIn();
                }
            });
        });
    });
</script>