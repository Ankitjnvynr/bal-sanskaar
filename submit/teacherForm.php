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
      <form action="../parts/teacher_form.php" method="post">
        <div class="text-center fw-bold my-2 text-danger fs-3">Teacher Details</div>
        
        <div class="row d-flex gap-1 flex-wrap fs-7 px-2">
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="type" class="form-label">Teacher/Head Teacher</label>
                <select id="type" name="type" class="form-select"  required>
                    <?php
                    $arr = ['Teacher','Head Teacher'];
                    foreach ($arr as $value) {
                        if($value == $_GET['type']){
                            echo '<option selected value="'.$value.'">'.$value.'</option>';
                        }else{
                            echo '<option  value="'.$value.'">'.$value.'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" >
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="dob" class="form-label">DOB</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" >
            </div>
            
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" id="phone" name="phone" onkeypress="return onlyDigits(event)" size="10" minlength="10" maxlength="10" >
            </div>
            
           
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="countrySelect" class="form-label">Country</label>
                <select id="countrySelect" name="country" class="form-select " aria-label="Small select example" required="" onchange="loadState(this)" required>
                    <option value="country">Country</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">State</label>
                <select id="stateSelect" name="state" class="form-select " aria-label="Small select example" required="" onchange="loadDistrict(this)" required>
                    <option value="state">state</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">District</label>
                <select id="districtSelect" name="district" class="form-select " aria-label="Small select example" required="" onchange="loadTehsil (this)" required>
                    <option value="dis">district</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="state" class="form-label">Tehsil</label>
                <select id="tehsil" name="tehsil" class="form-select " aria-label="Small select example" required=""  required>
                    <option value="teh">teh</option>
                </select>
            </div>
            <div class=" form-item  bg-light shadow-sm rounded p-2 flex-grow-1 flex-shrink-0">
                <label for="center" class="form-label">Center</label>
                <select id="center" name="center" class="form-select " aria-label="Small select example" required=""  required>
                    <option value="center1">Center1</option>
                    <option value="Center2">Center2</option>
                    <option value="Center3">Center3</option>
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
    <script src="../js/script.js"></script>
  </body>
</html>
