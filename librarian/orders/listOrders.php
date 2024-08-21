<!--php --> 
<?php
session_start();

//get categories
include "../../include/functions.php";


//user should connect to see this page 
if(!isset($_SESSION["Name"])){
  header("location:../login.php");
}



$date = date("y-m-d");
if(!empty($_POST)){
  //if search button is clicked
  $transactions = searchCustomerTrunsactions($_POST["search"]);
}else if(isset($_GET["statut"]) && $_GET['statut'] == "late"){
  $transactions = getLateReturns($date);

}else if(isset($_GET["statut"]) && $_GET['statut'] == "unreturned"){
  $transactions = getUnreturnedTransactions($date);
}else{
  $transactions = getTransactions($date);
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
  <form action="listOrders.php" method="POST">

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
                <a class="nav-link active" href="#">
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
                <a class="nav-link" href="../customers/listCustomers.php">
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
            <h1 class="h2">Orders</h1>
            <div>
                <?php
                      echo $_SESSION["Name"].' #'.$_SESSION["idLibrarian"];
                ?>
            </div>
        </div>
        <div class="text-right mb-3">
            <a href="listOrders.php" class="btn btn-dark">History</a>
            <a href="listOrders.php?statut=late" class="btn btn-danger" >Late</a>
            <a href="listOrders.php?statut=unreturned" class="btn btn-warning" >Currently borrowed</a>

        </div>

        
        <?php
        //returned
        if(isset($_GET['returned']) && $_GET['returned'] == "done"){
            print '
            <div class="alert alert-success">
                The Transation of "'.$_GET["name"].'" has been Updated successfully
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
                    <th scope="col">firstName</th>
                    <th scope="col">lastName</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Transaction date</th>
                    <th scope="col">numberOfDays</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            $i = 0;
                            foreach($transactions as $transaction){
                                $i++;
                                print '
                                <tr>
                                    <th scope="row">'.$i.'</th>
                                    <td>'.$transaction["Id"].'</td> 
                                    <td>'.$transaction["Email"].'</td> 
                                    <td>'.$transaction["firstName"].'</td> 
                                    <td>'.$transaction["lastName"].'</td> 
                                    <td>'.$transaction["BookTitle"].'</td> 
                                    <td>'.$transaction["DateE"].'</td> 
                                    <td>'.$transaction["numberOfDays"].'</td> 
                                    <td>';?>
                                    <?php


                                    if($transaction['returned'] == 'yes'){
                                      print'
                                        <p class="text-success">Returned<p>
                                        
              
                                        </td>
                                    </tr>
                                    ';
                                    }else{
                                      print'                                          
                                        <a onclick="return popUpDelete();" href="return.php?name='.$transaction['firstName'].' '.$transaction['lastName'].'&ISBN='.$transaction['ISBN'].'&id='.$transaction['Id'].'&customerID='.$transaction['userID'].'" class="btn btn-success">Returned</a>
                
                                        </td>
                                    </tr>
                                    ';

                                    }
                                    ?>
                        <?php
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
    return confirm("Are you sure you want to mark this transaction as returned? Once confirmed, the book will be considered returned and cannot be reversed.?")
  }
  function popUpSuspend(){
    return confirm("Do you really want to suspend this Customer?")

  }
  function popUpUnsuspend(){
    return confirm("Do you really want to unsuspend this Customer?")

  }

</script>
</html>