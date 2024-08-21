<!--php --> 
<?php
session_start();

//get categories
include "../../include/functions.php";


//clear cookies

//user should connect to see this page 
if(!isset($_SESSION["idLibrarian"])){
  header("location:../login.php");
}

//get all conversations :
$allConversations = getAllConversations();


  
if(!empty($_POST)){
    //if search button is clicked
    $customers = searchCustomers($_POST["search"]);
  }else if(isset($_GET["statut"]) && $_GET['statut'] == "late"){
    //$date = date("y-m-d");
    //echo '<script>alert("date = '.$date.'")</script>';
    $customers = getLateReturners();

  }else if(isset($_GET["statut"]) && $_GET['statut'] == "suspend"){
    $customers = getSuspended();
  }else{
    $customers = getCustomer();
  }


?>


<!--html -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Librarian : Categories</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="../../mycss/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../mycss/bootstrap/dashboard.css" rel="stylesheet">
  </head>

  <body>
  <form action="listCustomers.php" method="POST">

    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../profileLibrarian.php">Company name</a>
      <input class="form-control form-control-dark w-100" name="search" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../../disconnect.php">Sign out</a>
        </li>
      </ul>
    </nav>
    </form>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link " href="#">
                  <span data-feather="home"></span>
                  Home <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../orders/listOrders.php">
                  <span data-feather="file"></span>
                  Orders
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../book/listBooks.php">
                  <span data-feather="shopping-cart"></span>
                  Books
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="users"></span>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../categories/listCategories.php">
                  <span data-feather="bar-chart-2"></span>
                  Categories
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../profileLibrarian.php">
                  <span data-feather="layers"></span>
                  Profile
                </a>
              </li>
            </ul>

          </div>
        </nav>


 



        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Customers</h1>
            <div>
                <?php
                      echo $_SESSION["Name"].' #'.$_SESSION["idLibrarian"];
                ?>
            </div>
        </div>
        <div class="text-right mb-3">
            <a href="listCustomers.php" class="btn btn-primary">All customers</a>
            <a href="listCustomers.php?statut=late" class="btn btn-danger" >Late Returners</a>
            <a href="listCustomers.php?statut=suspend" class="btn btn-warning" >Suspended Customers</a>

        </div>

        
        <?php
        //delete
        if(isset($_GET['delete']) && $_GET['delete'] == "done"){
            print '
            <div class="alert alert-success">
                The Customer "'.$_GET["name"].'" has been deleted successfully
            </div>
        
        ';
        }
        
        ?>

        <?php
        //Edit
        if(isset($_GET['action']) && $_GET['action'] == "suspend"){
            print '
            <div class="alert alert-success">
               The Customer "'.$_GET["name"].'" has been suspended successfully
            </div>
        
        ';
        }
        ?>

      <?php
        //Edit
        if(isset($_GET['action']) && $_GET['action'] == "unsuspend"){
            print '
            <div class="alert alert-success">
               The Customer  has been suspended successfully
               The suspension for Customer "'.$_GET["name"].'" has been lifted successfully.
            </div>
        
        ';
        }
        ?>

        <?php
        //duplicated error 
        //Edit
        if(isset($_GET['error']) && $_GET['error'] == "duplicated"){
          print '
          <div class="alert alert-danger">
              Librarian "'.$_GET["name"].'" already exist
          </div>
      
        ';
        }
        ?> 





          <div class="table">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Email</th>
                    <th scope="col">PWD</th>
                    <th scope="col">firstName</th>
                    <th scope="col">lastName</th>
                    <th scope="col">Address</th>
                    <th scope="col">Country</th>
                    <th scope="col">City</th>
                    <th scope="col">Zip</th>
                    <?php
                    if(isset($_GET["statut"]) && $_GET['statut'] == "late"){
                      print'
                      <th scope="col">numberOfDays</th>
                      ';
                    }
                    ?>
                    <th scope="col" style="width: 300px">Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            $i = 0;
                            foreach($customers as $customer){
                                $i++;
                                $id = "tableUserId".$i;
                                $firstName = "tableUserFirstName".$i;
                                $lastName = "tableUserLastName".$i;
                                print '
                                <tr>
                                    <th scope="row">'.$i.'</th>
                                    <td id="tableUserId'.$i.'">'.$customer["Id"].'</td> 
                                    <td>'.$customer["Email"].'</td> 
                                    <td>'.$customer["PWD"].'</td> 
                                    <td id="tableUserFirstName'.$i.'">'.$customer["firstName"].'</td> 
                                    <td id="tableUserLastName'.$i.'">'.$customer["lastName"].'</td> 
                                    <td >'.$customer["Address"].'</td> 
                                    <td>'.$customer["Country"].'</td> 
                                    <td>'.$customer["City"].'</td> 
                                    <td>'.$customer["Zip"].'</td>';
                                    if(isset($_GET["statut"]) && $_GET['statut'] == "late"){
                                      print'
                                      <td>'.$customer["numberOfDays"].'</td> 
                                      ';
                                    }
                                    print'
                                    <td class="row col-12" style="width: 300px">
                                    <a  onclick="sendUserId('.$id.','.$firstName.','.$lastName.');" href="#" class="btn btn-primary col-5" data-toggle="modal" id="message" data-target="#messageConversation">Message</a>';
                                    if($customer['Statut'] == 'active'){
                                      print '
                                      <a onclick="return popUpSuspend();"  href="suspend.php?name='.$customer['firstName'].' '.$customer['lastName'].'&Email='.$customer['Email'].'&id='.$customer['Id'].'&action=suspend" class="btn btn-warning col-4">Suspend</a>
                                      ';
                                    }else{
                                      print '
                                      <a onclick="return popUpUnSuspend();"  href="suspend.php?name='.$customer['firstName'].' '.$customer['lastName'].'&Email='.$customer['Email'].'&id='.$customer['Id'].'&action=unsuspend" class="btn btn-warning col-4">Unsuspend</a>
                                      
                                      ';
                                    }
                                    print '
                                    </td>
                                </tr>
                                ';
                            }
                        
                        ?>    


                </tbody>
            </table>
          </div>

        <!-- Button trigger modal -->
        <!-- Modal message-->
        
        <div class="modal hide fade in" id="messageConversation" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="conversationName"><?php echo $_COOKIE["userName"] ?></h5>

              </div>
              <div class="conversation p-4" id ="conversation" style="width: 100%; max-width: 600px; max-height: 400px; overflow-y: auto; margin: auto;">
                <?php
                $messages = showMessages($_COOKIE['id_variable']);
                
                foreach($messages as $message){
                  if($message["senderID"] != $_SESSION["idLibrarian"]){
                    print '
                    <div title="'.$message['dateM'].'" class="message other-message" style="background-color: #E0E0E0; float: left; clear: both; padding: 10px; margin-bottom: 5px; border-radius: 5px;word-break: break-all; overflow-wrap: break-word;">'.$message["content"].'</div>';
                  }else{
                    print '
                    <div title="'.$message['dateM'].'" class="message your-message" style="background-color: #DCF8C6; float: right; clear: both; padding: 10px; margin-bottom: 5px; border-radius: 5px;word-break: break-all; overflow-wrap: break-word;">'.$message["content"].'</div>';
                  }
                }  
                
                //unset($_COOKIE['id_variable']);
                //delete the cookie (setting it empty (3600 means 1hour ago))
                //setcookie('id_variable', '', time() - 3600, '/');
                
                  ?>

              </div>
              <form action="../sendMessage.php" method="POST">
                <input type="hidden" name="receiverID" id="userId">
                <input type="hidden" name="senderID" value=<?php echo $_SESSION["idLibrarian"] ?> id="librarianID">

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
        </div>
        <!-- Modal Modify -->

        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../myJavascript/bootstrap/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../myJavascript/bootstrap/popper.min.js"></script>
    <script src="../../myJavascript/bootstrap/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="../../myJavascript/bootstrap/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
  </body>

  <script>
  
  function sendUserId(id,firstName,lastName){ //how does that work ? xD check it later
    //userId= document.getElementById(id)

    //set id
    userId = id.innerText;
    formUserId= document.getElementById('userId')
    formUserId.value = userId
    console.log(formUserId.value)
    //set cookies
    document.cookie = "id_variable = " + userId
    document.cookie = "userName= " + firstName.innerText +" "+lastName.innerText
    console.log(document.cookie)
    //set user full name
    //firstName = document.getElementById(firstName).innerText
    //lastName = document.getElementById(lastName).innerText
    console.log(lastName)
    //document.getElementById("conversationName").innerText = firstName.innerText +" "+lastName.innerText

    
    
  }
  function cancelCookies(){
    window.location.reload();
  }

  function popUpDelete(){
    return confirm("Do you really want to delete this Customer?")
  }
  function popUpSuspend(){
    return confirm("Do you really want to suspend this Customer?")

  }
  function popUpUnSuspend(){
    return confirm("Do you really want to unsuspend this Customer?")

  }


</script>
</html>