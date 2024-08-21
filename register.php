<?php 
include "include/functions.php";
$categories = getCategories();

$showAlert=0;
if(!empty($_POST)){

  if(addUser($_POST)){
    $showAlert =1 ;
  }else{
    $showAlert = 2;
  }
  //echo "done";
}



//user that is already connected cannot acces to this page
session_start();
if(isset($_SESSION["connexion"])){
  header("location:index.php");
}


//countries
$countries= getCountries();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
    <!-- sweet alert2 (cdn)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.7/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <?php 
    include "mycss/style.php"
    ?>
</head>
<body>
    <!-- Nav-->
    <?php
    include "include/header.php"
    ?>
      <!-- Section -->
      <div class="row col-16 formDiv mx-auto">
        <h1 class="text-center" style="color:blue">Sign up</h1>
        <form action="register.php" method="POST" id="form" enctype="multipart/form-data" >
          <div id="parentForm">
            <div class="row">
                <div class="col">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" name="firstName" class="form-control" id="firstName" required="True" >
                    <span id="verificationFN" ></span>
                </div>
                <div class="col">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" name="lastName" class="form-control" id="lastName" required="True">
                    <span id="verificationLN" ></span>

                </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>

              <input type="email" name="Email" class="form-control" id="email" aria-describedby="emailHelp" required="True">
              <span id="verificationEmail" ></span>
              <?php
                //duplicated mail error 
                //Edit
                if(isset($_GET['error']) && $_GET['error'] == "duplicated"):?>
                  
                  <div class="alert alert-danger">
                      This Email already exist
                  </div>
                
                
              <?php endif;?>
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="pwd" class="form-label">Password</label>
              <input type="password" name="PWD" class="form-control" id="pwd" required>
              <span id="verificationPwd" ></span>

            </div>
            <div class="mb-3">
                <label for="pwdConfirmation" class="form-label">Password Confirmation</label>
                <input type="password" name="pwdConfirmation" class="form-control" id="pwdConfirmation" required>
                <span id="verificationPwdV" ></span>
                <div class="invalid-feedback" id="pwdVerification">
                </div>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="showPassword" onclick="show();">
              <label class="form-check-label" for="showPassword">Show Password</label>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="Address" class="form-control" id="address" required>
                <span id="verificationAddress" ></span>

            </div>

            <div class="row">
                <div class="col">
                    <label for="inputCountry" class="form-label">Country</label>
                    <select id="inputCountry" name="Country" class="form-control" required>
                      <option selected>Choose...</option>
                      <?php
                      foreach($countries as $country):?>
                          <option value="<?= $country["Country"]?>"><?= $country["Country"]?></option>
                      
                      <?php endforeach;  ?>
                    </select>
                    <span id="verificationCountry" ></span>
                </div>

                <div class="col">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="City" class="form-control" id="city" required>
                    <span id="verificationCity" ></span>

                </div>

                <div class="col">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" name="Zip" class="form-control" id="zip" required>
                    <span id="verificationZip" ></span>

                </div>
            </div>

            <div class="mb-3 pt-3">
                <!--Image-->
                  <div>
                    <div class="d-flex justify-content-center mb-4" id="userFace">
                        <img id="selectedAvatar" src="images/placeholder_avatar.jpg"
                        class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" alt="example placeholder" />

                    </div>
                        <!-- face detection -->
                        <?php
                        //duplicated mail error 
                        //Edit
                        if(isset($_GET['error']) && $_GET['error'] == "noFace"){
                          print '
                          <div class="alert alert-danger">
                          Oops! It seems like there\'s no face detected in the image you uploaded. Please try again. Thank you!     
                          </div>
                          ';
                        }
                        ?>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-primary btn-rounded">
                            <label class="form-label text-white m-1" for="customFile2">Choose Image</label>
                            <!-- from upload -->
                            <input type="file" accept="image/*" name="uploaded_image_data" class="form-control d-none" id="customFile2" onchange="displaySelectedImage(event, 'selectedAvatar')" />
                            <!-- from camera -->
                            <input type="hidden" name="captured_image_data" id="captured_image_data">
                            <!-- choose image --> 
                            <input type="text" name="chooseImage" id="chooseImage" style="display:none"/>
                            <!-- image value -->
                            <input type="text" name="imageValue" id="imageValue" style="display:none"/>
  
                
                        </div>
                        <button type="button" class="btn btn-primary"style="margin-left: 10px;" onclick="camera();">From webcam</button>
                        
                        <!-- <a href="testUpload.php"  target="_blank" class="btn btn-primary"style="margin-left: 10px;" >From webcam</a> -->
                      </div>
                      <div id="my_camera" class="pre_capture_frame mx-auto" ></div>
                      <button type="button" class="btn btn-primary" onclick="take_snapshot();" id="takeSnap" style="display:none;">Take Snapshot</button>
  
  
                  </div>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>

          </div>
            <button type="button" class="btn btn-primary" onclick="duplicate()">Add family member</button>
            <button type="submit" class="btn btn-primary" onclick="multiVerifications()">Create an account</button>

        </form>   
    </div>
      


      
    <!-- Footer -->
    <?php
    include "include/footer.php"
    ?>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="text/javascript" src="myJavascript/scriptRegister.js"></script>
<script type="text/javascript" src="myJavascript/scriptVerifImage.js"></script>


    <!-- Required library for webcam -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>


    <!-- sweet alert --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.7/sweetalert2.all.min.js" integrity="sha512-sCRQAGZoT2SOdF+QT+pzQaJn2SP9K4t27Au967tsnf3gZNfHcKrkAKudpV2JBu16wsMouvG8C7iNV+dmMgDBgQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 

    <?php
    if(isset($_GET["error"]) && ($_GET["error"] == "duplicated" ||$_GET["error"] == "noFace" )):?>
      
      <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
        allowOutsideClick: false,
        allowEscapeKey: false
      });
      </script>
      
    <?php endif; ?>
    
    <?php if ($showAlert ==1):?>

      
      <script>

      Swal.fire({
        icon: 'success',
        title: 'success',
        text: 'account created successfully!',
        allowOutsideClick: false,
        allowEscapeKey: false
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'connection.php'; // Redirect to connection.php
        }
      });     
      </script>

      
      

    
    <?php endif; ?>

</html>