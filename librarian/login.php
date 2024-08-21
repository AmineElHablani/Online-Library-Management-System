<?php 
include "../include/functions.php";

//$categories = getCategories();

//connexion
$librarian = true; 

if(!empty($_POST)){
  $librarian = librarianConnection($_POST);

  //if mail and password == correct 
  if( $librarian != false && count($librarian) > 0){
    //create session 
    session_start();
    $_SESSION["idLibrarian"] = $librarian["Id"];
    $_SESSION["Email"] = $librarian["Email"];
    $_SESSION["PWD"] = $librarian["PWD"];
    $_SESSION["Name"] = $librarian["Name"];
    //$_SESSION["userImage"] = $user["userImage"];


    //redirection to profile page
    header('location:profileLibrarian.php');
  }
}


//user that is already connected cannot acces to this page
session_start();

if(isset($_SESSION["firstName"])){
  //header("location:index.php");
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
    include "../mycss/style.php"
    ?>

</head>
<body>
    <!-- Nav-->
      <!-- Section -->
    <div class="row col-16 formDiv mx-auto w-30 " style="margin-bottom:200px">
        <h1 class="text-center" style="color:blue">Sign in</h1>

        <form action="login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="Email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" name="PWD" class="form-control" id="exampleInputPassword1">
            </div>
            
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>   
    </div>
      


    <!-- Footer -->
    <?php
    include "../include/footer.php"
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- sweet alert --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.7/sweetalert2.all.min.js" integrity="sha512-sCRQAGZoT2SOdF+QT+pzQaJn2SP9K4t27Au967tsnf3gZNfHcKrkAKudpV2JBu16wsMouvG8C7iNV+dmMgDBgQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 

    <?php
    if($user == false){
      print "
      <script>
      Swal.fire({
        icon: 'error',
        title: 'Failed!',
        text: 'the contact details you entered are not linked to any account!',
      });
      </script>
      ";
    }
    
    
      ?>




</html>