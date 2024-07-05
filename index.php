<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GIEO Gita-Bal Sanskaar Yojna</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/header.css">
</head>

<body class="bg-warning-subtle position-relative">


  <?php
  $logoPath = 'imgs/logo.png';
  $loginBtnPath = 'admin/';
  include 'parts/_header.php';

  ?>



  <div class="container my-2">
    <div class="row">
      <div  class="col-md">
        <img width="100%" src="imgs/hero.jpg" alt="" />
        <p class="fs-3 text-center fw-bolder">🌹*बाल संस्कार योजना*🌹</p>
        <p style="text-align: justify">
          *आज की सबसे महत्वपूर्ण आवश्यकता है, हमारी भावी पीढ़ी संस्कारवान
          बने,,अपनी परंपराओं अपने ग्रंथो को जाने*🌺 *इसी दृष्टिकोण से पूज्य
          गुरुदेव गीता मनीषी स्वामी श्री ज्ञानानंद जी महाराज के सानिध्य में
          जीओगीता द्वारा एक विशेष अभियान "बाल संस्कार योजना" ..... प्रारंभ की
          गई है,* *जिसके अंतर्गत हर नगर में अधिक से अधिक स्थानों , गली मोहल्ले
          सैक्टर आदि में 5 से 15 वर्ष के बच्चों के लिए सप्ताह में एक दिन एक
          घंटे की कक्षा लगाने की योजना है,,अनेक नगरों में ये कक्षाएं मई के
          अंतिम रविवार से प्रारंभ हो चुकीं हैं,* 💫 *इस अभियान में महिला
          मंडलों का विशेष योगदान है*🌻 *अतः अन्य सभी समितियों के संयोजक/
          अध्यक्ष/पदाधिकारियों से विशेष आग्रह है कि अपने महिला मंडलों के साथ
          समन्वय से इस अभियान को अपने नगर में अधिक से अधिक स्थानों गली मोहल्ले
          में प्रारंभ कर,अपने नगर के बच्चों को संस्कारित बनाने के पुनीत कार्य
          में सहयोग करें, अपने नगर समाज देश के प्रति अपने दायित्व का निर्वाह
          करें*
        </p>

      </div>

      <div class="col-md">
        <form method="get" class="card p-2" action="./submit">
          <img width="100%" src="imgs/guruji.jpg" alt="">
          <span class="fw-bold mt-3">Want to join:-</span>
          <label for="type"></label>
          <select name="type" class="form-select form-select-sm" aria-label="Small select example" required>
            <option value="" selected>select user type</option>
            <option value="Student">Student</option>
            <option value="Teacher">Teacher</option>
            <option value="Head Teacher">Head Teacher</option>
          </select>
          <input type="submit" value="Next" class="btn btn-danger my-2">
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>