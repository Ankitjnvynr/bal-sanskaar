<?php include '_header.php'; ?>
<?php

require_once '../config/_db.php';

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

    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        echo "<div class='alert alert-danger'>File is not an image.</div>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
    } else {
       
        // Generate a new file name using the current timestamp
        $timestamp = time(); // Current timestamp
        $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION); // Extract the file extension
        $new_file_name = $timestamp . "." . $file_extension; // New file name

        // Define the target file path
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Update the database with the new file name
            $sql_update = "UPDATE teachers SET pic = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $new_file_name, $user_id);
            $stmt_update->execute();
            $stmt_update->close();

            $update = true;
            
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
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
         "<div class='alert alert-success'>The file " . htmlspecialchars(basename($_FILES["profile_picture"]["name"])) . " has been uploaded.</div>";
    }
    ?>
    <div class=" my-4">
        <!-- Profile Card -->
        <div class="row align-items-center">
            <!-- Profile Picture -->
            <div class="col-md-4 text-center">
                <img src="../imgs/uploads/<?php echo htmlspecialchars($teacher['pic'] ?? 'defaultimg.png'); ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                <!-- Profile Picture Upload Form -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                    <div class="my-3">
                        <input type="file" name="profile_picture" class="form-control form-control-sm bg-danger-subtle" accept="image/*" required>
                        <button type="submit" class="btn btn-danger mt-2">Upload New Photo</button>
                    </div>
                </form>
            </div>
            <!-- Profile Data -->
            <div class="col-md-8">
                <div class="card profile-card shadow-sm ">
                    <div class="card-body d-flex align-items-center flex-column">
                        <h4 class="card-title mb-1"><?php echo htmlspecialchars($teacher['name'] ?? ''); ?></h4>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($teacher['email'] ?? ''); ?></p>
                        <p class="card-text"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($teacher['dob'] ?? ''); ?></p>
                        <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($teacher['phone'] ?? ''); ?></p>
                        <p class="card-text"><strong>Country:</strong> <?php echo htmlspecialchars($teacher['country'] ?? ''); ?></p>
                        <p class="card-text"><strong>State:</strong> <?php echo htmlspecialchars($teacher['state'] ?? ''); ?></p>
                        <p class="card-text"><strong>District:</strong> <?php echo htmlspecialchars($teacher['district'] ?? ''); ?></p>
                        <p class="card-text"><strong>Tehsil:</strong> <?php echo htmlspecialchars($teacher['tehsil'] ?? ''); ?></p>
                        <p class="card-text"><strong>Center:</strong> <?php echo htmlspecialchars($teacher['center'] ?? ''); ?></p>
                        <div class="text-center my-3">
                            <!-- <a href="update_teacher.php" class="btn btn-danger col-5">Edit Profile</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-y-scroll">
            <div class="container my-2">
                <!-- Profile Card and other content here -->

                <!-- Change Password Section -->
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#changePasswordCollapse" aria-expanded="true" aria-controls="changePasswordCollapse">
                                Change Password
                            </button>
                        </h2>
                        <div id="changePasswordCollapse" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form class="row g-3" id="changePasswordForm">
                                    <div class="col-sm-12 mb-3">
                                        <label for="currentPassword" class="form-label">Current Password</label>
                                        <input type="password" class="form-control form-control-lg" id="currentPassword" name="current_password" placeholder="Enter current password" required>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="newPassword" class="form-label">New Password</label>
                                        <input type="password" class="form-control form-control-lg" id="newPassword" name="new_password" placeholder="Enter new password" required>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control form-control-lg" id="confirmPassword" name="confirm_password" placeholder="Re-enter new password" required>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-danger btn-lg">Change Password</button>
                                    </div>
                                    <div id="message" class="mt-3 text-center"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Include Bootstrap JS and CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


        <script>
            // Password change function
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);

                    fetch('../parts/change_password.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('message').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                                setTimeout(() => {
                                    const collapseElement = new bootstrap.Collapse(document.getElementById('changePasswordCollapse'), {
                                        toggle: false
                                    });
                                    collapseElement.hide(); // Close the accordion
                                    document.getElementById('message').innerHTML = '';
                                }, 4000);
                            } else {
                                document.getElementById('message').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                            }
                        })
                        .catch(error => {
                            document.getElementById('message').innerHTML = `<div class="alert alert-danger">An error occurred while processing the request.</div>`;
                        });
                });
            });
        </script>

        <?php include '_footer.php'; ?>
