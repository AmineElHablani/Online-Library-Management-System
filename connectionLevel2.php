<?php 
include "include/functions.php";

$categories = getCategories();

session_start();


//connexion
$user = true; 


if(!empty($_POST)){
  if(isset($_SESSION["banTime"]) && $_SESSION["banTime"] > time() ){
    echo '<script>alert("hak mazelt mbani barra dez doura w arja3")</script>';
  }else if(isset($_SESSION["banTime"]) && $_SESSION["banTime"] < time()){
    echo "fel else if <br>";
    unset($_SESSION["banTime"],$_SESSION["attemptions"]);
    $user= userConnectionLevel2_v2($_SESSION["userImage"],$_POST["captured_image_data"],$_SESSION['idUser']);
    if(isset($_SESSION["attemptions"])){
      $_SESSION["attemptions"] += 1;
    }else{
      $_SESSION["attemptions"] = 1;
    }
    if( $user != false){
      $_SESSION["Connexion"] = "accepted";
  
    }
  }else{
    echo "fel else <br>";

  //$user= userConnectionLevel2($_SESSION["userImage"],$_POST["captured_image_data"]);
  $user= userConnectionLevel2_v2($_SESSION["userImage"],$_POST["captured_image_data"],$_SESSION['idUser']);
  if(isset($_SESSION["attemptions"])){
    $_SESSION["attemptions"] += 1;
  }else{
    $_SESSION["attemptions"] = 1;
  }
  //if mail and password == correct 
  if( $user != false){
    //create session 
    #session_start();
    $_SESSION["Connexion"] = "accepted";

    //redirection to profile page
    //header('location:profile.php'); 
  }else if ($_SESSION["attemptions"] >= 3){
    $next30min = time() + (10 * 60); //ban 10 min 
    $_SESSION["banTime"] = $next30min;
    //header("location:action/sendEmail.php?idUser=".$_SESSSION["idUser"]);  //get user, then send an email
    echo '<script>alert("YA ensssen 7ot mandhreeek ma tfaddednich walla trit na3ne3")</script>';
  }
  }

}



//user that is already connected cannot acces to this page
//session_start();

if(isset($_SESSION["Connexion"])){
  header("location:index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" href=/style.css?v=<?php echo time(); ?>">

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
    <div class="row col-16 formDiv mx-auto w-30 " style="margin-bottom:200px">
        <h1 class="text-center" style="color:blue">Sign in <span style="color:red;">Level 2 </span></h1>

        <form action="connectionLevel2.php" method="POST">
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
                        if(isset($_GET['error']) && $_GET['error'] == "noFace"):?>
                          
                          <div class="alert alert-danger">
                          Oops! It seems like there\'s no face detected in the image you uploaded. Please try again. Thank you!     
                          </div>
                          
                        
                        <?php endif; ?>
                    <div class="d-flex justify-content-center">
                            <!-- from camera --> <!-- contain snapshot -->
                            <input type="hidden" name="captured_image_data" id="captured_image_data">
                
                        <button type="button" class="btn btn-primary"style="margin-left: 10px;" onclick="camera();">From webcam</button>
                        
                        <!-- <a href="testUpload.php"  target="_blank" class="btn btn-primary"style="margin-left: 10px;" >From webcam</a> -->
                      </div>
                      <div id="my_camera" class="pre_capture_frame mx-auto" ></div>
                      <button type="button" class="btn btn-primary" onclick="take_snapshot();" id="takeSnap" style="display:none;">Take Snapshot</button>
  
  
                  </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>   
    </div>
      


    <!-- Footer -->
    <?php
    include "include/footer.php"
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    <!-- quotes --> 

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


    <!-- sweet alert --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.7/sweetalert2.all.min.js" integrity="sha512-sCRQAGZoT2SOdF+QT+pzQaJn2SP9K4t27Au967tsnf3gZNfHcKrkAKudpV2JBu16wsMouvG8C7iNV+dmMgDBgQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 

    <?php
    if($user == false):?>
      
      <script>
      Swal.fire({
        icon: 'error',
        title: 'Failed!',
        text: 'the contact details you entered are not linked to any account!',
      });
      </script>
      
    
    
    
     <?php endif; ?>




</html>