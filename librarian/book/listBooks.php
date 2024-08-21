<!--php --> 
<?php
session_start();

//get categories
include "../../include/functions.php";

if(!empty($_POST)){
    //if search button is clicked
    $books = search($_POST["search"]);
}else{
    $books = getBooks();
}
$categories = getCategories();

//user should connect to see this page 
if(!isset($_SESSION["idLibrarian"])){
  header("location:../login.php");
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

    <title>Librarian : Products</title>


    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="../../mycss/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../mycss/bootstrap/dashboard.css" rel="stylesheet">

    <!-- css --> 
    <style>
        .scrollable {
            width: 100%; /* adjust as needed */
            height: 100px; /* adjust as needed */
            overflow: auto;
        }
        .scrollableTatble {
            width: 100%; /* adjust as needed */
            height: 600px; /* adjust as needed */
            overflow: auto;
        }
        .fixTableHead { 
        overflow-y: auto; 
        max-height: 600px; 
        } 
        .fixTableHead thead th { 
        position: sticky; 
        top: 0; 
        } 
        table { 
        border-collapse: collapse;         
        width: 100%; 
        } 
        th, 
        td { 
        padding: 8px 15px; 
        border: 2px solid black; 
        } 
        th { 
        color:white;
        background: black; 
    } 

        
    </style>
  </head>

  <body>
  <form action="listBooks.php" method="POST">

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
                <a class="nav-link active" href="#">
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
            <h1 class="h2">Books</h1>
            <div>
                <?php
                      echo $_SESSION["Name"].' #'.$_SESSION["idLibrarian"];
                ?>
            </div>
        </div>

        
        <?php
        // add
        if(isset($_GET["add"]) && $_GET['add'] == "done"){
            print '
                <div class="alert alert-success">
                    Book "'.$_GET['name'].'" added successfully
                </div>
            
            ';
        }
        ?>
        
        <?php
        //delete
        if(isset($_GET['delete']) && $_GET['delete'] == "done"){
            print '
            <div class="alert alert-success">
                Book "'.$_GET["name"].'" deleted successfully
            </div>
        
        ';
        }
        
        ?>

        <?php
        //Edit
        if(isset($_GET['edit']) && $_GET['edit'] == "done"){
            print '
            <div class="alert alert-success">
                Book "'.$_GET["old"].'" is changed to "'.$_GET["new"].'" successfully
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



        
        <div class="text-right mb-3">
            <a href="" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add Book</a>
        </div>
          <div  class="scrollableTatble fixTableHead">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th classe="th" scope="col">#</th>
                    <th scope="col">BookTitle</th>
                    <th scope="col">BookAuthor</th>
                    <th scope="col">Price </th>
                    <th scope="col">Available in stock </th>
                    <th scope="col">PublishYear</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">ImageURL</th>
                    <th scope="col">PublishMonth</th>
                    <th scope="col">PublishDay</th>
                    <th scope="col">Language </th>
                    <th scope="col">Description</th>
                    <th scope="col">previewLink</th>
                    <th scope="col">infoLink </th>
                    <th scope="col">categories</th>
                    <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody  class="scrollableTatble">
                        <?php
                            $i = 0;
                            foreach($books as $book){
                                $i++;
                                print '
                                <tr class="td">
                                    <th scope="row">'.$i.'</th>
                                    <td>'.$book["BookTitle"].'</td> 
                                    <td>'.$book["BookAuthor"].'</td> 
                                    <td>'.round($book["Price"],2).'</td> 
                                    <td>'.$book["stock"].'</td> 
                                    <td>'.$book["PublishYear"].'</td> 
                                    <td>'.$book["Publisher"].'</td> 
                                    <td>'.$book["Image-URL-L"].'</td> 
                                    <td>'.$book["PublishMonth"].'</td> 
                                    <td>'.$book["PublishDay"].'</td> 
                                    <td>'.$book["Language"].'</td> 
                                    <td><div class="scrollable"><p>'.$book["Description"].'</p></div></td> 
                                    <td>'.$book["previewLink"].'</td> 
                                    <td>'.$book["infoLink"].'</td> 
                                    <td>'.$book["categories"].'</td> 
                                    <td>
                                    <a class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#editModal'.$book["ISBN"].'">Edit</a>
                                    <a onclick="return popUpDelete();" href="delete.php?name='.$book['BookTitle'].'&id='.$book['ISBN'].'" class="btn btn-danger">Delete</a>
                                    
            
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
                            <!-- BookTitle --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="BookTitle" id="BookTitle" placeholder="Book title">
                            </div>
                            <!-- BookAuthor --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="BookAuthor" id="BookAuthor" placeholder="Book author">
                            </div>
                            <!-- PublishYear --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="PublishYear" id="PublishYear" placeholder="Publish Year">
                            </div>
                            <!-- Publisher --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="Publisher" id="Publisher" placeholder="Publisher">
                            </div>
                            <!-- Image-URL-L --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="Image-URL-L" id="Image-URL-L" placeholder="Image-URL">
                            </div>
                            <!-- PublishMonth --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="PublishMonth" id="PublishMonth" placeholder="Publish month">
                            </div>
                            <!-- PublishDay --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="PublishDay" id="PublishDay" placeholder="Publish day">
                            </div>
                            <!-- Language --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="Language" id="Language" placeholder="Language">
                            </div>
                            <!-- Description --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="Description" id="Description" placeholder="Description">
                            </div>
                            <!-- previewLink --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="previewLink" id="previewLink" placeholder="preview Link">
                            </div>
                            <!-- infoLink --> 
                            <div class="form-group">
                                <input type="text" class="form-control" required name="infoLink" id="infoLink" placeholder="info Link">
                            </div>
                            <!-- categories --> 
                            <div class="form-group">
                                <select class="form-control" name="categories" id="categories">
                                    <option>category </category>
                                    <?php
                                    foreach($categories as $category){
                                    print '<option value="'.$category["categoryNAME"].'">'.$category['categoryNAME'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Price --> 
                            <div class="form-group">
                                <input type="number" class="form-control" required name="Price" id="Price" placeholder="Price">
                            </div>
                            <!-- quantity --> 
                            <div class="form-group">
                                <input type="number" class="form-control" required name="stock" id="stock" placeholder="stock">
                            </div>
                            <!-- librarian --> 
                            <input type="hidden" name="librarianID" value="<?php echo $_SESSION["Id"]?>">

                        </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal modify2 -->
        <?php
            foreach($books as $index => $book){ ?>
            <div class="modal fade" id="editModal<?php echo $book["ISBN"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <!--old -->
                              <input type="hidden" name="id" value="<?php echo $book['ISBN']?>">
                              <input type="hidden" name="old" value="<?php echo $book["BookTitle"]?>">
                              <!-- BookTitle --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="BookTitle" id="BookTitle" placeholder="Book title">
                              </div>
                              <!-- BookAuthor --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="BookAuthor" id="BookAuthor" placeholder="Book author">
                              </div>
                              <!-- PublishYear --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="PublishYear" id="PublishYear" placeholder="Publish Year">
                              </div>
                              <!-- Publisher --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="Publisher" id="Publisher" placeholder="Publisher">
                              </div>
                              <!-- Image-URL-L --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="Image-URL-L" id="Image-URL-L" placeholder="Image-URL">
                              </div>
                              <!-- PublishMonth --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="PublishMonth" id="PublishMonth" placeholder="Publish month">
                              </div>
                              <!-- PublishDay --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="PublishDay" id="PublishDay" placeholder="Publish day">
                              </div>
                              <!-- Language --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="Language" id="Language" placeholder="Language">
                              </div>
                              <!-- Description --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="Description" id="Description" placeholder="Description">
                              </div>
                              <!-- previewLink --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="previewLink" id="previewLink" placeholder="preview Link">
                              </div>
                              <!-- infoLink --> 
                              <div class="form-group">
                                  <input type="text" class="form-control" required name="infoLink" id="infoLink" placeholder="info Link">
                              </div>
                              <!-- categories --> 
                              <div class="form-group">
                                  <select class="form-control" name="categories" id="categories">
                                      <option>category </category>
                                      <?php
                                      foreach($categories as $category){
                                      print '<option value="'.$category["categoryNAME"].'">'.$category['categoryNAME'].'</option>';
                                      }
                                      ?>
                                  </select>
                              </div>

                              <!-- Price --> 
                              <div class="form-group">
                                  <input type="number" class="form-control" required name="Price" id="Price" placeholder="Price">
                              </div>
                              <!-- librarian --> 
                              <input type="hidden" name="librarianID" value="<?php echo $_SESSION["Id"]?>">
                          </div>

                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Add</button>
                              </div>
                      </form>
                  </div>
              </div>
          </div>
            
        <?php 
            }
        ?>

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

    <!-- bootstrap categories -->
    
  </body>


  <script>
  function popUpDelete(){
    return confirm("Do you really want to delete this item?")
  }

</script>
</html>