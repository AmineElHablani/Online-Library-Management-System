

<!-- php  -->
<?php 
  
  //start session 
  session_start();



  include "include/functions.php";
  $categories = getCategories();
  $publishers = getPublishers();
  $authors = getAuthors();
  $years = getPublishYear();

  $books = getBooks();
  //get array column "price"
  $arrayPrice = array_column($books, 'Price');
  $arrayRating = array_column($books, 'Rating');

  
//isset , empty 
  
//search (in search we use the last request)


//type of selection
if(isset($_GET["selection"]) && $_GET["selection"] == "topRated"){
    $selection ="Rating desc";

}else if (isset($_GET["selection"]) && $_GET["selection"] != "mostSold"){
    $selection="PublishYear desc,PublishMonth desc,PublishDay DESC";
}

//initialize request
$request = "SELECT * FROM books";

// multiple pages 
$sizeOfData = count(array_column($books, 'ISBN'));
$numberOfPages = $sizeOfData  / 20;

//$sampleSize = 20;
//$startIndex = 0;
//$restSize = $sizeOfData - 20 ;

if(isset($_GET["p"])){
    $startIndex = ((int)$_GET["p"] *20) -20;  // offset 

    //$restSize = $sizeOfData - 20 ; //verify if i stil have data 
    $restSize = $sizeOfData - $startIndex ; //verify if i stil have data 
    //if($restSize>= 0){
    if($restSize>= 20){
        $sampleSize = 20;    //limit
    }else{
        $sampleSize = $sizeOfData - $startIndex;  //limit
    }
    if(isset($_GET["selection"]) && $_GET["selection"] == "mostSold"){
        if(isset($_GET["minPrice"])){
            $request = createRequest2($_GET);
            $books=getBooksByPage($sampleSize,$startIndex,$request);   //3awwed a9ra code w fassa5 tbalibz ki t99oum 
            //size of data 
            $sizeOfData = getNumberOfPages($request);
        }else{
            $books=getBooksBySalesPage($sampleSize,$startIndex);
            //$books=getBooksBySales();
            //size of data 
            $sizeOfData = getNumberOfPagesBySales();

        }

    }else if (isset($_GET["minPrice"]) ){
        $request = createRequest($_GET,$selection);
        $books= getBooksByPage($sampleSize,$startIndex,$request);

        //get size 
        $sizeOfData = getNumberOfPages($request);

    }else if (isset($_GET["bookTitle"])){
        $books = getBooksBySelectionPage($sampleSize,$startIndex,$selection,$_GET["bookTitle"]);

        $sizeOfData = getNumberOfPagesBySelection($selection);
    }else if (isset($_GET["name"])){
        $books = getBooksBySelectionPageCategory($sampleSize,$startIndex,$selection,$_GET["name"]);

        $sizeOfData = getNumberOfPagesBySelection($selection);
    }else {
        $books = getBooksBySelectionPage($sampleSize,$startIndex,$selection,""); 

        $sizeOfData = getNumberOfPagesBySelection($selection);
    }


    $numberOfPages = ceil($sizeOfData[0] / 20);


}




?>


<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font --> 
    <link href="https://fonts.cdnfonts.com/css/lt-funk" rel="stylesheet">
                                
    <?php
    include "mycss/styleIndex.php"
    ?>


</head>
<body>
    <!-- Nav-->
    <?php
    include "include/header.php"
    ?>
    <br>


     <div class="body-Page">
         <div class="section row col-12 m-0">
           <div class="side col-2 sideBar">
           
                <div class="text-bg-primary p-3 text-center sideBarLabel" style="font-weight: 700;">Filter</div>
               <form action="books.php" method="GET">
                    <!-- hidden pagenumber -->
                    <input type="hidden" name="p" value = "1" id="pageNumber">
                    <!-- hidden selection -->
                    <input type="hidden" name="selection" value = "<?php echo $_GET['selection'] ?>"id="selection">
                    <div class="mb-3 category">
                        <select class="form-select" name="category" aria-label="Default select example" onclick="testFilter(this);">
                            <option selected>Category</option>
                            <?php
                                foreach($categories as $category){
                                    print '
                                        <option value="'.$category["categoryNAME"].'">'.$category["categoryNAME"].'</option>
                                    ';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 author">
                            <select class="form-select" name="author" aria-label="Default select example">
                            <option selected>Author</option>
                            <?php
                                foreach($authors as $author){
                                    print '
                                        <option value="'.$author["authorName"].'">'.$author["authorName"].'</option>
                                    ';
                                }
                            ?>

                        </select>
                    </div>
                    <div class="mb-3 publisher">
                            <select class="form-select"  name="publisher" aria-label="Default select example">
                            <option selected>Publisher</option>
                            <?php
                                foreach($publishers as $publisher){
                                    print '
                                        <option value="'.$publisher["publisherName"].'">'.$publisher["publisherName"].'</option>
                                    ';
                                }
                            ?>

                        </select>
                    </div>
                    <div class="mb-3 price">
                        <p class="btn btn-dark" id="labelPrice" style="width:100%;margin-bottom:2px;" onclick="DisplayFilter(this);">Price</p>
                        <div class="Price-intervall" style="display: none;" >
                            <span hidden>not clicked</span>
                            <label for="customRange1">min</label>
                            <input type="range" class="form-range" name="minPrice" value=<?php echo min($arrayPrice)?> id="customRange1" min=<?php echo min($arrayPrice)?> max=<?php echo max($arrayPrice)+1?> oninput="this.nextElementSibling.value = this.value">
                            <output></output><br>
                            <label for="customRange1">max</label>
                            <input type="range" class="form-range" name="maxPrice" value=<?php echo max($arrayPrice)?> id="customRange1" min=<?php echo min($arrayPrice)?> max=<?php echo max($arrayPrice) +1?> oninput="this.nextElementSibling.value = this.value">
                            <output></output><br>
                        </div>

                    </div>
                    <div class="mb-3 publishYear">
                            <select class="form-select" name="year" aria-label="Default select example">
                            <option selected>Publisher Year</option>
                            <?php
                                foreach($years as $year){
                                    print '
                                        <option value="'.$year["PublishYear"].'">'.$year["PublishYear"].'</option>
                                    ';
                                }
                            ?>

                        </select>
                    </div>
                    <div class="mb-3">
                            <p class="btn btn-dark" id="labelPrice" style="width:100%;margin-bottom:2px;" onclick="DisplayFilter(this);">Rating</p>
                            <div class="Price-intervall" style="display: none;" >
                                <span hidden>not clicked</span>
                                <label for="customRange1">min</label>
                                <input type="range" class="form-range" name="minRate" value=<?php echo min($arrayRating)?> id="customRange1" min=<?php echo min($arrayRating)?> max=<?php echo max($arrayRating)?> oninput="this.nextElementSibling.value = this.value">
                                <output></output><br>
                                <label for="customRange1">max</label>
                                <input type="range" class="form-range" name="maxRate" value=<?php echo max($arrayRating)?> id="customRange1" min=<?php echo min($arrayRating)?> max=<?php echo max($arrayRating)?> oninput="this.nextElementSibling.value = this.value">
                                <output></output><br>
                            </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Filter</button>
               </form>
           </div>
   
   
   
           <div class="side col-10 mainContent">
               <div class="container mx-auto row col-12 p-5 books">
                 <?php 
                 foreach($books as $book):  #for x in liste ?>
                 
                   <div class="col-3 p-2">
                   <div class="card product" style="width: 16rem;border-radius:20px" title="<?= $book["BookTitle"] ?>">
                       <img src="<?= $book['Image-URL-L']?> " class="card-img-top" alt="<?= $book["BookTitle"]?>" width="100" height="300">
                       <div class="card-body">
                         <h5 class="card-title title" ><?= $book['BookTitle']?> </h5>
                         <p class="card-text"><?= round($book['Price'],2)?>$</p>
                         <a href="produit.php?isbn=<?= $book["ISBN"]?>" class="btn btn-dark">Read Details</a>

                         <?php if($book["stock"] > 0): ?>
                           
                               <span class="text-success m-3">Available</span>
                               </div>
                               </div>
                             </div> 
                         <?php else:?>
                           
                               <p class="text-danger m-4">out of stock</p>
                               </div>
                               </div>
                             </div> 
                         <?php endif;?>
         
                   
         
         
                <?php endforeach;?>
         
          
               </div>
           </div>
         </div>
     </div>



        <div class="part1" style="background-color: white;margin:0px">
            <nav aria-label="Page navigation pagination-lg m-0">
            <?php
                //if p =1
                if($_GET["p"]==1): ?>
                    
                    
                    
                    <ul class="pagination justify-content-center pagination-lg m-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link active" href="#">1</a></li>';
                        <?php if($numberOfPages >= 2):?>
                            
                            <li class="page-item"><a class="page-link" href="action/nextPage.php?next1=<?=($_GET["p"] + 1)?>">2</a></li>
                            
                                
                        <?php endif; ?>
                        <?php if($numberOfPages >=3):?>
                            
                            <li class="page-item"><a class="page-link" href="action/nextPage.php?next2=<?= ($_GET["p"] + 2)?>">3</a></li>
                            
                        <?php endif; ?>
                        <?php if($numberOfPages >= 2): ?>
                            
                                <li class="page-item">
                                    <a class="page-link" href="action/nextPage.php?next1=<?= ($_GET["p"] + 1)?>">Next</a>
                                </li>
                            </ul>
                            
                        <?php else: ?>
                            
                                        <li class="page-item">
                                        <a class="page-link disabled" href="#">Next</a>
                                    </li>
                                </ul>
                        
                        <?php endif; ?>
                

                
                
                <?php //else if p = numberofpages

                elseif($_GET["p"]== $numberOfPages): ?>
                    
                    <ul class="pagination justify-content-center pagination-lg m-0">
                        <li class="page-item">
                            <a class="page-link" href="action/nextPage.php?prev1=<?=($_GET['p'] - 1)?>" tabindex="-1">Previous</a>
                        </li>

                        <?php if($numberOfPages == 2):?>
                            
                                <li class="page-item"><a class="page-link" href="action/nextPage.php?prev1=<?= ($_GET['p'] - 1)?>"><?=($_GET['p'] - 1)?></a></li>
                            
                            
                        <?php elseif($numberOfPages >=3):?>
                            
                                <li class="page-item"><a class="page-link" href="action/nextPage.php?prev2=<?= ($_GET['p'] - 2)?>"><?= ($_GET['p'] - 2)?></a></li>
                                
                                <li class="page-item"><a class="page-link" href="action/nextPage.php?prev1=<?= ($_GET['p']-1)?>"><?= ($_GET['p']-1)?></a></li>
                            

                        <?php endif;?>
                            
                            
                            <li class="page-item"><a class="page-link active" href="#"><?= $_GET['p']?></a></li>
                            <li class="page-item">
                            <a class="page-link disabled" href="#">Next</a>
                        </li>
                    </ul>                   
                    
                

                

                <?php else : //else?>
                    
                    <ul class="pagination justify-content-center pagination-lg m-0">
                        <li class="page-item">
                            <a class="page-link" href="action/nextPage.php?prev1=<?= ($_GET['p']-1)?>">Previous</a>
                        </li>
                            <li class="page-item"><a class="page-link" href="action/nextPage.php?prev1=<?= ($_GET['p']-1)?>"><?= ($_GET["p"] - 1)?></a></li>
                            <li class="page-item"><a class="page-link active" href="#"><?= $_GET["p"]?></a></li>
                            <li class="page-item"><a class="page-link" href="action/nextPage.php?next1=<?= ($_GET["p"] + 1)?>"><?= ($_GET["p"] + 1)?></a></li>
                            <li class="page-item">
                            <a class="page-link" href="action/nextPage.php?next1=<?= ($_GET["p"] + 1)?>">Next</a>
                        </li>
                    </ul>
                    
                
                <?php endif;?>
            
            
            
            
            
            

            
            ?>

            </nav>
      </div>

      
      <!---!
 -->
      
</body>
<footer>

</footer>
      <!-- Footer -->
      <?php
      include "include/footer.php"
      ?>
<script src="myJavascript/indexJavascript.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    <!-- quotes --> 

    <script>
        var quotesArray = <?php echo(json_encode($quotes)); ?>;
        window.onload = function() {
          randomQuote(quotesArray);
        };



    </script>

</html>