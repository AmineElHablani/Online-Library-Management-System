<!--php --> 
<?php
session_start();

//get categories
include "../../include/functions.php";


//user should connect to see this page 
if(!isset($_SESSION["adminName"])){
  header("location:../login.php");
}


if(!empty($_POST)){
    //if search button is clicked
    $customers = searchCustomers($_POST["search"]);
  }else if(isset($_GET["statut"]) && $_GET['statut'] == "late"){
    $date = date("y-m-d");
    $customers = getLateReturners($date);

  }else if(isset($_GET["statut"]) && $_GET['statut'] == "suspend"){
    $customers = getSuspended();
  }else{
    $customers = getCustomer();
  }

//get retardataire 


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
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../profileAdmin.php">Company name</a>
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
                <a class="nav-link" href="../librarians/listLibrarians.php">
                  <span data-feather="award"></span>
                  Librarians
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="listCustomers.php">
                  <span data-feather="users"></span>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../profileAdmin.php">
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
                      echo $_SESSION["adminName"].' #'.$_SESSION["idAdmin"];
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
        if(isset($_GET['edit']) && $_GET['edit'] == "done"){
            print '
            <div class="alert alert-success">
               The Customer "'.$_GET["old"].'" has been suspended successfully
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
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            $i = 0;
                            foreach($customers as $customer){
                                $i++;
                                print '
                                <tr>
                                    <th scope="row">'.$i.'</th>
                                    <td>'.$customer["Id"].'</td> 
                                    <td>'.$customer["Email"].'</td> 
                                    <td>'.$customer["PWD"].'</td> 
                                    <td>'.$customer["firstName"].'</td> 
                                    <td>'.$customer["lastName"].'</td> 
                                    <td>'.$customer["Address"].'</td> 
                                    <td>'.$customer["Country"].'</td> 
                                    <td>'.$customer["City"].'</td> 
                                    <td>'.$customer["Zip"].'</td> 
                                    <td >';
                                    if($customer['Statut'] == 'active'){
                                      print '
                                      <a onclick="return popUpSuspend();"  href="suspend.php?name='.$customer['firstName'].' '.$customer['lastName'].'&Email='.$customer['Email'].'&id='.$customer['Id'].'&action=suspend" class="btn btn-warning">Suspend</a>
                                      ';
                                    }else{
                                      print '
                                      <a onclick="return popUpUnSuspend();"  href="suspend.php?name='.$customer['firstName'].' '.$customer['lastName'].'&Email='.$customer['Email'].'&id='.$customer['Id'].'&action=unsuspend" class="btn btn-warning">Unsuspend</a>
                                      
                                      ';
                                    }
                                    print '
                                    <a onclick="return popUpDelete();" href="delete.php?name='.$customer['firstName'].' '.$customer['lastName'].'&Email='.$customer['Email'].'&id='.$customer['Id'].'" class="btn btn-danger">Delete</a>
                                    
            
                                    </td>
                                </tr>
                                ';
                            }
                        
                        ?>    


                </tbody>
            </table>
          </div>

        <!-- Button trigger modal -->
        <!-- Modal ADD-->

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