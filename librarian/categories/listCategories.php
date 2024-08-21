<!--php --> 
<?php
session_start();

//get categories
include "../../include/functions.php";


//user should connect to see this page 
if(!isset($_SESSION["idLibrarian"])){
  header("location:../login.php");
}



if(!empty($_POST)){
  //if search button is clicked
  $categories = searchCategory($_POST["search"]);
}else{
  $categories = getCategories();
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
  <form action="listCategories.php" method="POST">

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
                <a class="nav-link" href="../customers/listCustomers.php">
                  <span data-feather="users"></span>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">
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
            <h1 class="h2">Categories</h1>
            <div>
                <?php
                      echo $_SESSION["Name"].' #'.$_SESSION["idLibrarian"];
                ?>
            </div>
        </div>
        <div class="text-right mb-3">
            <a href="" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add Category</a>
        </div>
        
        <?php
        // add
        if(isset($_GET["add"]) && $_GET['add'] == "done"){
            print '
                <div class="alert alert-success">
                    category "'.$_GET['name'].'" added successfully
                </div>
            
            ';
        }
        ?>
        
        <?php
        //delete
        if(isset($_GET['delete']) && $_GET['delete'] == "done"){
            print '
            <div class="alert alert-success">
                category "'.$_GET["name"].'" deleted successfully
            </div>
        
        ';
        }
        
        ?>

        <?php
        //Edit
        if(isset($_GET['edit']) && $_GET['edit'] == "done"){
            print '
            <div class="alert alert-success">
                category "'.$_GET["old"].'" is changed to "'.$_GET["new"].'" successfully
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
              category "'.$_GET["name"].'" already exist
          </div>
      
        ';
        }
        ?>





          <div class="table">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            $i = 0;
                            foreach($categories as $category){
                                $i++;
                                print '
                                <tr>
                                    <th scope="row">'.$i.'</th>
                                    <td>'.$category["categoryNAME"].'</td> 
                                    <td>
                                    <a class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#editModal'.$category["NUMC"].'">Edit</a>
                                    <a onclick="return popUpDelete();" href="delete.php?name='.$category['categoryNAME'].'&id='.$category['NUMC'].'" class="btn btn-danger">Delete</a>
                                    
            
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Catgory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="add.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" required name="categoryNAME" id="categoryNAME" placeholder="Category's name">
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>




        <!-- Modal Modify -->

        <?php
            foreach($categories as $index => $category){ ?>
                
                <div class="modal fade" id="editModal<?php echo $category["NUMC"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="edit.php" method="POST">
                                <div class="modal-body">
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="<?php echo $category['NUMC']?>">
                                            <input type="hidden" name="old" value="<?php echo $category["categoryNAME"]?>">
                                            <input type="text" class="form-control" required name="categoryNAME" id="categoryNAMEmodify" placeholder="New name">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


        <?php
            }
        
        ?>

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
    return confirm("Do you really want to delete this item?")
  }

</script>
</html>