<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GIEO Gita-Bal Sanskaar Yojna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <style>
        .form-item {
            flex: 1 0 230px;
        }
        .fs-7 {
            font-size: 0.9rem;
        }
        .hidden {
            display: none;
        }
        .clickable-row {
            cursor: pointer;
        }
        .details-section {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .back-btn {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="bg-warning-subtle">
    <div class="container my-5">
        

        <!-- Teacher Access Section -->
        <div id="teacherSection" class="row hidden">
            <!-- Student List -->
            <div class="col-md-8">
                <div class="card p-4 shadow-sm">
                    <div class="text-center fw-bold my-2 text-success fs-3">Student Details</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Father's Name</th>
                                <th>Mother's Name</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Center</th>
                            </tr>
                        </thead>
                        <tbody id="studentTable">
                            <!-- Student rows will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Student Details View -->
            <div class="col-md-4 hidden" id="studentDetailsSection">
                <div class="details-section">
                    <button class="btn btn-secondary back-btn" onclick="goBackToList()">Back</button>
                    <div id="studentDetailsContent">
                        <!-- Detailed student view will be inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Headmaster Access Section -->
        <div id="headmasterSection" class="row hidden">
            <!-- Teacher List -->
            <div class="col-md-8">
                <div class="card p-4 shadow-sm">
                    <div class="text-center fw-bold my-2 text-danger fs-3">Teachers and Students</div>
                    <h4>Teachers</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Center</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTable">
                            <!-- Teacher rows will be inserted here -->
                        </tbody>
                    </table>

                    <h4>Students</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Father's Name</th>
                                <th>Mother's Name</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Center</th>
                            </tr>
                        </thead>
                        <tbody id="allStudentTable">
                            <!-- All student rows will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Teacher's Students Details View -->
            <div class="col-md-4 hidden" id="teacherStudentDetailsSection">
                <div class="details-section">
                    <button class="btn btn-secondary back-btn" onclick="goBackToHeadmasterView()">Back</button>
                    <div id="teacherStudentDetailsContent">
                        <!-- Detailed view of teacher's students will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Sample Data
        const teachers = [
            {
                name: "Mr. Smith",
                subject: "Mathematics",
                phone: "+1234567890",
                email: "smith@example.com",
                center: "Center A",
                students: [
                    { name: "John Doe", dob: "01-01-2010", fatherName: "Richard Roe", motherName: "Jane Doe", country: "Country A", state: "State A", district: "District A", center: "Center A" },
                    { name: "Jane Smith", dob: "02-02-2011", fatherName: "John Smith", motherName: "Mary Smith", country: "Country A", state: "State B", district: "District B", center: "Center A" }
                ]
            },
            {
                name: "Mrs. Johnson",
                subject: "Science",
                phone: "+0987654321",
                email: "johnson@example.com",
                center: "Center B",
                students: [
                    { name: "Alice Johnson", dob: "03-03-2012", fatherName: "Tom Johnson", motherName: "Sue Johnson", country: "Country B", state: "State C", district: "District C", center: "Center B" }
                ]
            }
        ];

        function handleLogin(event) {
            event.preventDefault(); // Prevent form submission
            const role = document.getElementById("role").value;

            // Hide login form
            document.getElementById("loginForm").classList.add("hidden");

            if (role === "teacher") {
                document.getElementById("teacherSection").classList.remove("hidden");
                loadStudentDetails(teachers[0].students); // Assuming teacher will see their students
            } else if (role === "headmaster") {
                document.getElementById("headmasterSection").classList.remove("hidden");
                loadTeacherDetails();
                loadAllStudentDetails();
            }
        }

        function loadStudentDetails(students) {
            const studentTable = document.getElementById("studentTable");
            studentTable.innerHTML = ""; // Clear previous rows
            students.forEach(student => {
                const row = `<tr class="clickable-row" onclick="showStudentDetails(${JSON.stringify(student).replace(/"/g, '&quot;')})">
                    <td>${student.name}</td>
                    <td>${student.dob}</td>
                    <td>${student.fatherName}</td>
                    <td>${student.motherName}</td>
                    <td>${student.country}</td>
                    <td>${student.state}</td>
                    <td>${student.district}</td>
                    <td>${student.center}</td>
                </tr>`;
                studentTable.innerHTML += row;
            });
        }

        function loadTeacherDetails() {
            const teacherTable = document.getElementById("teacherTable");
            teacherTable.innerHTML = ""; // Clear previous rows
            teachers.forEach((teacher, index) => {
                const row = `<tr class="clickable-row" onclick="showTeacherStudents(${index})">
                    <td>${teacher.name}</td>
                    <td>${teacher.subject}</td>
                    <td>${teacher.phone}</td>
                    <td>${teacher.email}</td>
                    <td>${teacher.center}</td>
                </tr>`;
                teacherTable.innerHTML += row;
            });
        }

        function loadAllStudentDetails() {
            const allStudentTable = document.getElementById("allStudentTable");
            allStudentTable.innerHTML = ""; // Clear previous rows
            teachers.forEach(teacher => {
                teacher.students.forEach(student => {
                    const row = `<tr>
                        <td>${student.name}</td>
                        <td>${student.dob}</td>
                        <td>${student.fatherName}</td>
                        <td>${student.motherName}</td>
                        <td>${student.country}</td>
                        <td>${student.state}</td>
                        <td>${student.district}</td>
                        <td>${student.center}</td>
                    </tr>`;
                    allStudentTable.innerHTML += row;
                });
            });
        }

        function showStudentDetails(student) {
            const studentDetailsContent = document.getElementById("studentDetailsContent");
            studentDetailsContent.innerHTML = `
                <h4>Student Details</h4>
                <p><strong>Name:</strong> ${student.name}</p>
                <p><strong>DOB:</strong> ${student.dob}</p>
                <p><strong>Father's Name:</strong> ${student.fatherName}</p>
                <p><strong>Mother's Name:</strong> ${student.motherName}</p>
                <p><strong>Country:</strong> ${student.country}</p>
                <p><strong>State:</strong> ${student.state}</p>
                <p><strong>District:</strong> ${student.district}</p>
                <p><strong>Center:</strong> ${student.center}</p>
            `;

            document.getElementById("studentDetailsSection").classList.remove("hidden");
            document.getElementById("teacherSection").classList.add("hidden");
        }

        function showTeacherStudents(index) {
            const teacher = teachers[index];
            const teacherStudentDetailsContent = document.getElementById("teacherStudentDetailsContent");
            teacherStudentDetailsContent.innerHTML = `<h4>${teacher.name}'s Students</h4>`;

            teacher.students.forEach(student => {
                const studentDetails = `<div class="mb-2">
                    <p><strong>Name:</strong> ${student.name}</p>
                    <p><strong>DOB:</strong> ${student.dob}</p>
                    <p><strong>Father's Name:</strong> ${student.fatherName}</p>
                    <p><strong>Mother's Name:</strong> ${student.motherName}</p>
                    <p><strong>Country:</strong> ${student.country}</p>
                    <p><strong>State:</strong> ${student.state}</p>
                    <p><strong>District:</strong> ${student.district}</p>
                    <p><strong>Center:</strong> ${student.center}</p>
                    <hr />
                </div>`;
                teacherStudentDetailsContent.innerHTML += studentDetails;
            });

            document.getElementById("teacherStudentDetailsSection").classList.remove("hidden");
            document.getElementById("headmasterSection").classList.add("hidden");
        }

        function goBackToList() {
            document.getElementById("studentDetailsSection").classList.add("hidden");
            document.getElementById("teacherSection").classList.remove("hidden");
        }

        function goBackToHeadmasterView() {
            document.getElementById("teacherStudentDetailsSection").classList.add("hidden");
            document.getElementById("headmasterSection").classList.remove("hidden");
        }
    </script>
</body>
</html>
