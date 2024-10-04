<?php include '_header.php'; ?>

<style>
#drop-area {
    border: 2px dashed #6c757d;
    /* padding: 20px; */
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

#fileName {
    margin-top: 10px;
    font-weight: bold;
    color: #007bff;
}

.alert {
    margin-top: 20px;
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <div
        class="h4 text-center shadow-sm my-1 p-1 align-items-center rounded-2 text-danger d-flex justify-content-between">
        <i data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas" class="fa-solid fa-bars d-md-none"></i>
        Welcome: <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE); ?>
    </div>

    <form id="uploadForm" class="shadow-lg p-2 rounded bg-light  d-flex gap-2">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="title" class="form-label">PDF Title</label>
                <input type="text" class="form-control form-control-sm" id="title" placeholder="Enter PDF title"
                    required>
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">PDF Subtitle</label>
                <textarea class="form-control form-control-sm" id="subtitle" rows="2" placeholder="Enter PDF subtitle"
                    required></textarea>
            </div>
        </div>

        <div class=" flex-1 col-md-6">
            <div id="drop-area" class="border border-dashed p-2 text-center m-1" style="border-radius: 10px;">
                <p  class="lead m-0 p-0">Drag & Drop PDF here</p>
                <p class="m-0 p-0" >or</p>
                <input type="file" id="fileInput" accept="application/pdf" class="form-control" hidden>
                <button type="button" class="btn btn-primary"
                    onclick="document.getElementById('fileInput').click();">Browse File</button>
                <div id="fileName"></div>
            </div>

            <div id="uploadStatus" class="mt-3"></div>

            <button type="submit" class="btn btn-success w-100">Upload PDF</button>
        </div>
    </form>
    <hr>

    <div class="my-1">
        <h5>All Syllabus</h5>
        <div id="allDocuments" class="d-flex flex-wrap my-2 gap-2"></div>
    </div>
</main>

<?php include '_footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>



function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        // Send AJAX request to delete the record
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../parts/deletesyllabus.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Handle success response
                alert(xhr.responseText); // You can show a success message here
                // Optionally, reload the page or remove the card from the DOM
                 // Reload the page to reflect the changes
                 $('#allDocuments').load('allSyllabusLoad.php');
            }
        };
        
        xhr.send("id=" + id);
    }
}





$(document).ready(function() {
    const dropArea = $('#drop-area');
    const fileInput = $('#fileInput');
    const uploadForm = $('#uploadForm');
    const uploadStatus = $('#uploadStatus');
    const fileName = $('#fileName');

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

    // Handle file selection
    fileInput.on('change', function() {
        const files = this.files;
        handleFiles(files);
    });

    function handleDrop(e) {
        const dt = e.originalEvent.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files.length) {
            const file = files[0];
            const fileSizeLimit = 5 * 1024 * 1024; // 5 MB size limit
            if (file.type !== 'application/pdf') {
                showError('Please upload a valid PDF file.');
            } else if (file.size > fileSizeLimit) {
                showError('File size must not exceed 5 MB.');
            } else {
                fileInput[0].files = files; // Populate hidden input with dropped file
                fileName.text(`Selected file: ${file.name}`);
                clearError(); // Clear previous errors
            }
        }
    }

    // Show error messages
    function showError(message) {
        uploadStatus.html(`<div class="alert alert-danger">${message}</div>`).fadeIn();
    }

    // Clear error messages
    function clearError() {
        uploadStatus.html('').fadeOut();
    }

    // Handle form submission with jQuery AJAX
    uploadForm.on('submit', function(e) {
        e.preventDefault();

        const title = $('#title').val();
        const subtitle = $('#subtitle').val();
        const file = fileInput[0].files[0];

        if (!file) {
            showError('Please upload a PDF file.');
            return;
        }

        const formData = new FormData();
        formData.append('title', title);
        formData.append('subtitle', subtitle);
        formData.append('file', file);

        $.ajax({
            url: '../parts/syllabusUpload.php', // Replace with your server-side upload script URL 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#allDocuments').load('allSyllabusLoad.php');
            console.log(response);
            try {
                newres = parse.json(response)
                console.log(newres);
                
            } catch (error) {
                
            }
                uploadStatus.html(
                    '<div class="alert alert-success">File uploaded successfully!</div>'
                    ).fadeIn();
                fileName.text(''); // Clear file name after success
                uploadForm[0].reset(); // Reset the form fields
                clearError(); // Clear any error messages
            },
            error: function(jqXHR, textStatus, errorThrown) {
                let errorMessage = 'File upload failed.';
                if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                    errorMessage = jqXHR.responseJSON.error;
                }
                showError(errorMessage);
            }
        });
    });
    $('#allDocuments').load('allSyllabusLoad.php');

   
});
</script>