<?php

include "include/functions.php";
session_start();
$categories = getCategories();

$id = $_SESSION["idUser"];
$conn = connect();

//get user :
$request = "SELECT * FROM users WHERE Id= $id";
$result= $conn ->query($request);
$user= $result-> fetch();

//message 
if(!empty($_POST)){
  
  $librarianId = $_SESSION["idLibrarian"];
  $userID = $_SESSION["userID"];
  $content = $_POST["message"];
  $dateM = date('Y-m-d H:i:s');


  $request = "INSERT INTO messages(senderID,receiverID,content,dateM) VALUES ('$librarianId','$userID','$content','$dateM')";

  $result = $conn->query($request);
}


//get tables (borrowing history and message)

if(!isset($_Get["variable"])){
  $request= "SELECT e.*,b.* FROM books b,emprunt e WHERE e.userID = $id AND e.bookID = b.ISBN";//njib l id mel table user bel where nameuser
  $result= $conn->query($request);
  $history= $result->fetchAll(); 
  $test=true;
  

}
if(isset($_Get["variable"]) && $_GET["variable"]=="history"){
  //prepare a select statement
  $request= "SELECT * FROM emprunt WHERE userID= $id"; //njib l id mel table user bel where nameuser
  $result= $conn->query($request);
  $history= $result->fetchAll(); 
  $test=true;
} elseif(isset($_Get["variable"]) && $_GET["variable"]=="message"){
  $test=false;

  $request= "SELECT * FROM messages WHERE receiverID = $id";
  $result= $conn->query($request);
  $messages= $result->fetchAll(); 
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <!-- Nav-->

    <link href="mycss/profile.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
  <!-- Nav-->
<?php
include "include/header.php";
?>



<!--end navbar-->

<div class="card mb-4" style="max-width: 70%;padding:50px; margin-left: 160px;margin-top: 100px; background-color: rgba(255, 255, 255, 0.7);font-size: large;">
  <div class="row g-0 mx-auto" style="width:1000px;">
    <div class="col-md-3" >
      <img src=<?= $user['userImage']?> class="img-fluid rounded-start" alt="..." style="margin-left: 10px;margin-top: 5px;width: 100%;">
    </div>
    <div class="col-md-9">
      <div class="card-body" style="margin-left: 20px;">
      <p>id :# <?= $user['Id']?> </p>
        <h5 class="card-title">
          <?= $user['firstName']." ".$user['lastName']?></h5>
        <p class="card-text">
        <?= $user['Email']?><br>
          
          <!-- date of account creation: <br> -->
        </p>
        <?php  if($user['Statut']== "active"){
          $statuColor = "text-success";
        }else{
          $statuColor = "text-danger";
        }
        ?>
        <p >Statut : <span class=<?php echo $statuColor?> ><?= $user['Statut']?> </span><br></p>
       
      </div>
      
    </div>
    <div>
        
          <div class="d-grid gap-2 d-md-block " style="margin-left: 750px;margin-bottom: 5px;">
            <a class="btn btn-dark " href="profile.php?variable=history">history</a>
            <a class="btn btn-dark " href="profile.php?variable=message">messages</a>
          
          </div>
        

        <div class="card" style="width: 940px;margin-left: 10px; background-color: rgba(255, 255, 255, 0.5);" >
          <div class="card-body">
          <div class="tables container">
                <?php

                if(isset($_GET["variable"]) && $_GET["variable"]=="message"){
                  $messages = showMessages($_SESSION['idUser']);
                  if(isset($messages[0]['senderID'])){
                    if($messages[0]['senderID'] != $_SESSION['idUser']){
                      $librarianID = $messages[0]['senderID'];
                    }else{
                      $librarianID = $messages[0]['receiverID'];
                    }
                    $librarian = getLibrarianById($librarianID);

                    
                ?>
              <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="conversationName">Bibliothecaire : <?php echo $librarian["Name"]?></h5>

              </div>
              <div class="conversation p-4" id ="conversation" style="width: 100%; max-width: 1000px; max-height: 400px; overflow-y: auto; margin: auto;">
                
                
                <?php foreach($messages as $message):?>
                  <?php if($message["senderID"] != $_SESSION["idUser"]):?>
                    
                    
                    <div title="<?= $message['dateM']?>" class="message other-message" style="background-color: #E0E0E0; float: left; clear: both; padding: 10px; margin-bottom: 5px; border-radius: 5px;word-break: break-all; overflow-wrap: break-word;">
                    <?= $message["content"]?></div>
                  <?php else: ?>
                    
                    <div title="<?= $message['dateM']?> " class="message your-message" style="background-color: #DCF8C6; float: right; clear: both; padding: 10px; margin-bottom: 5px; border-radius: 5px;word-break: break-all; overflow-wrap: break-word;"><?= $message["content"]?></div>
                  <?php endif; ?> 
                 
                <?php
                //unset($_COOKIE['id_variable']);
                //delete the cookie (setting it empty (3600 means 1hour ago))
                //setcookie('id_variable', '', time() - 3600, '/');
                
                  endforeach; ?>

              </div>
              <form action="librarian/sendMessage.php" method="POST">
                <input type="hidden" name="receiverID" value=<?= $librarianID ?> id="librarianID">
                <input type="hidden" name="senderID" value=<?= $_SESSION['idUser'] ?> id="userId">
                <div class="form-group p-4">
                  <label for="exampleFormControlTextarea1">Send a message</label>
                  <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                  <div class="modal-footer">
                    <!-- reload page when i click cancel -->
                    <a href="deleteCookies.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Send</button>
                  </div>
                </div>
              </form>
          </div>
          <?php
                  }else{
                    print '
                    <div class="card-body"> </div>';
                  }

        }else{ ?>
        <div class="table" style=" max-height: 400px; overflow-y: auto;">
        <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">transaction Id</th>
                    <th scope="col">bookTitle</th>
                    <th scope="col">date</th>
                    <th scope="col">Returned</th>

                    </tr>
                </thead>
                <tbody>
                        <?php
                            $i = 0;
                            foreach($history as $h){
                                $i++;
                                print '
                                <tr>
                                    <th scope="row">'.$i.'</th>
                                    <td>'.$h["Id"].'</td> 
                                    <td>'.$h["BookTitle"].'</td> 
                                    <td>'.$h["DateE"].'</td> 
                                    <td>'.$h["returned"].'</td> 
                                    <td>';
                            }
                        ?>    


                </tbody>
            </table>
        <?php }   ?>
        </div>       

      </div>
            
          </div>
        </div>

    </div>
    
  </div>
</div>

















  
<!--end body-->  



    
</body>
<?php
include "include/footer.php";
?>
</html>