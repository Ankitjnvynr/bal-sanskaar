<?php include '_header.php'; ?>
<?php

require_once '../config/_db.php';
$alert = null;
$user_id = $_SESSION['id'];
$teacher = null;
$update = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    // Define the target directory
    $target_dir = "../imgs/uploads/";

    // Check if directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Fetch existing image name
    $sql_fetch = "SELECT pic FROM teachers WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $user_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    }
    $stmt_fetch->close();

    // Define target file path
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        $alert = "<div class='alert alert-danger'>File is not an image.</div>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        $alert =  "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $alert = "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $alert = "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
    } else {
        // Generate a new file name using the current timestamp
        $timestamp = time(); // Current timestamp
        $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION); // Extract the file extension
        $new_file_name = $timestamp . "." . $file_extension; // New file name

        // Define the target file path
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Delete old image if it exists and is not the default image
            if (!empty($teacher['pic']) && $teacher['pic'] != 'defaultimg.png') {
                $old_file_path = $target_dir . $teacher['pic'];
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            // Update the database with the new file name
            $sql_update = "UPDATE teachers SET pic = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $new_file_name, $user_id);
            $stmt_update->execute();
            $stmt_update->close();

            $update = true;
        } else {
            $alert = "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

if ($user_id > 0) {
    // Fetch existing data
    $sql_fetch = "SELECT * FROM teachers WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $user_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    }
    $stmt_fetch->close();
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
    <?php
    if ($update) {
        $alert = "<div class='alert alert-success'>The file " . htmlspecialchars($new_file_name) . " has been uploaded.</div>";
        echo $alert;
    }
    ?>
    <div class=" my-4">
        <!-- Profile Card -->
        <div class="row align-items-center">
            <!-- Profile Picture -->
            <div class="col-md-4 text-center">
                <img src="../imgs/uploads/<?php echo htmlspecialchars($teacher['pic'] ?? 'defaultimg.png'); ?>"
                    alt="Profile Picture" class="img-fluid rounded-circle"
                    style="width: 150px; height: 150px; object-fit: cover;">
                <!-- Profile Picture Upload Form -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="my-3">
                        <input type="file" name="profile_picture" class="form-control form-control-sm bg-danger-subtle"
                            accept="image/*" required>
                        <button type="submit" class="btn btn-danger mt-2">Upload New Photo</button>
                    </div>
                </form>
            </div>
            <!-- Profile Data -->
            <div class="col-md-8">
                <div class="card profile-card shadow-sm ">
                    <div class="card-body d-flex align-items-center flex-column">
                        <h4 class="card-title mb-1">
                            <?php echo htmlspecialchars($teacher['name'] ?? '');
                            ?> <span class="fs-6">(<?php echo $teacher['teacher_type']  ?>)</span></h4>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($teacher['email'] ?? ''); ?></p>
                        <p class="card-text"><strong>Date of Birth:</strong>
                            <?php echo htmlspecialchars($teacher['dob'] ?? ''); ?></p>
                        <p class="card-text"><strong>Phone:</strong>
                            <?php echo htmlspecialchars($teacher['phone'] ?? ''); ?></p>
                        <p class="card-text"><strong>Country:</strong>
                            <?php echo htmlspecialchars($teacher['country'] ?? ''); ?></p>
                        <p class="card-text"><strong>State:</strong>
                            <?php echo htmlspecialchars($teacher['state'] ?? ''); ?></p>
                        <p class="card-text"><strong>District:</strong>
                            <?php echo htmlspecialchars($teacher['district'] ?? ''); ?></p>
                        <p class="card-text"><strong>Tehsil:</strong>
                            <?php echo htmlspecialchars($teacher['tehsil'] ?? ''); ?></p>
                        <p class="card-text"><strong>Center:</strong>
                            <?php echo htmlspecialchars($teacher['center'] ?? ''); ?></p>
                        <div class="text-center my-3">
                            <!-- <a href="update_teacher.php" class="btn btn-danger col-5">Edit Profile</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="accordion fs-7" id="accordionPanelsStayOpenExample">
            <div class="accordion-item accordion-item-sm">
                <h2 class="accordion-header ">
                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                        aria-controls="panelsStayOpen-collapseOne">
                        Change Password
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse ">
                    <div class="accordion-body">
                        <form class="row d-flex gap-1 flex-wrap fs-7 px-2" id="changePasswordForm">
                            <div class="form-item">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password" class="form-control form-control-sm" id="currentPassword"
                                    name="current_password" required>
                            </div>
                            <div class="form-item">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control form-control-sm" id="newPassword"
                                    name="new_password" required>
                            </div>
                            <div class="form-item">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control form-control-sm" id="confirmPassword"
                                    name="confirm_password" required>
                            </div>
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-danger">Change Password</button>
                            </div>
                            <div id="message" class="mt-3 text-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // password change function 
    $(document).ready(function() {
        $('#changePasswordForm').on('submit', function(event) {
            event.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '../parts/change_password.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#message').html('<div class="alert alert-success">' + response
                            .message + '</div>');
                        $('#changePasswordForm')[0].reset(); // Clear the form
                        setTimeout(() => {
                            const collapseElement = new bootstrap.Collapse($(
                                '#panelsStayOpen-collapseOne'));
                            $('#message').html('');
                            collapseElement.hide(); // Close the accordion
                        }, 4000);
                    } else {
                        $('#message').html('<div class="alert alert-danger">' + response
                            .message + '</div>');
                    }
                },
                error: function() {
                    $('#message').html(
                        '<div class="alert alert-danger">An error occurred while processing the request.</div>'
                    );
                }
            });
        });
    });
</script>

<?php include '_footer.php'; ?>