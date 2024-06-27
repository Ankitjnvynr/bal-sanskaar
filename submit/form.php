<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GIEO Gita-Bal Sanskaar Yojna</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <style>
        .form-item{
            flex:1 0 230px;
        }
        .fs-7{
        font-size: 0.9rem;
        }
    </style>
  </head>

  <body class="bg-warning-subtle">
    <div class="container my-2">
      <form action="../parts/student_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Student Details</div>
        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-name" class="form-label">Father's Name</label>
                <input type="text" class="form-control form-control-sm" id="father-name" name="father-name" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-phone" class="form-label">Father's Phone</label>
                <input type="text" class="form-control form-control-sm" id="father-phone" name="father-phone" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="father-dob" class="form-label">Father's DOB</label>
                <input type="date" class="form-control form-control-sm" id="father-dob" name="father-dob" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-name" class="form-label">Mother's Name</label>
                <input type="text" class="form-control form-control-sm" id="mother-name" name="mother-name" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-phone" class="form-label">Mother's Phone</label>
                <input type="text" class="form-control form-control-sm" id="mother-phone" name="mother-phone" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="mother-dob" class="form-label">Mother's DOB</label>
                <input type="date" class="form-control form-control-sm" id="mother-dob" name="mother-dob" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select " aria-label="Small select example" required="" onchange="loadState(this)" required>
                    <option value="country">Country</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select " aria-label="Small select example" required="" onchange="loadState(this)" required>
                    <option value="country">state</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select " aria-label="Small select example" required="" onchange="loadState(this)" required>
                    <option value="country">district</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">Tehsil</label>
                <select id="districtSelect" name="tehsil" class="form-select " aria-label="Small select example" required="" onchange="loadState(this)" required>
                    <option value="country">Tehsil</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">Center</label>
                <select id="districtSelect" name="center" class="form-select " aria-label="Small select example" required="" onchange="loadState(this)" required>
                    <option value="country">Center1</option>
                    <option value="country">Center2</option>
                    <option value="country">Center3</option>
                </select>
            </div>
            
        </div>
        <div class="text-center my-3"><button  type="submit" class="btn btn-danger col-5">Submit</button></div>
      </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
