

<!-- php  -->
<?php 
  
  //start session 
  session_start();

  //require once

  include "include/functions.php";
  $categories = getCategories();

  
  

  
  $books = getBooks();
  if(isset($_SESSION["category"])){
    $books = findCategory($_SESSION['category']);
  }

  if(!empty($_POST)){
    //if search button is clicked
    if(isset($_SESSION["category"])){
      $books = searchWithCategory($_POST["search"],$_SESSION["category"]);
    }else{
      $books = search($_POST["search"]);
    }
  }

  //quotes 
  $quotes = getQuotes();


  //get Latest Releases
  $latestReleases = getLatestReleases();
  //get mostSold
  $mostSold =getMostRead();
  //get topRated
  $topRated = getTopRated();



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

    <div class="home">
      <div class="content">
        <h3>
          ARE YOU SEARCHING A BOOK ...?
        </h3>
        <h1 class="display-1">
          BIGGEST LIBRARY
        </h1>
        <p>Step into a world of words and wonder at <span>MyLibrary</span>. Welcome!</p>
      </div>
      <div class="content-right">
        <div class="left-quote">
          <img src="images/quote.png" alt="" id="left-quote">
        </div>
        <div class="quote">
          <div class="quote-group">
            <p class="quote-Text" id="quoteText">|</p>
            <p class="text-danger quoteTitle" id="quoteTitle">|</p>
          </div>
        </div>
        

        <div class="right-quote">
          <img src="images/double-quotes.png" alt="" id="right-quote">
        </div>
      </div>
    </div>
    <div class="welcome" onmouseenter="loadNumbers()">
        <span hidden id="isFirstLoad">this is the First Load</span>

        <div class="container text-center top">
          <h1>Welcome To The Library</h1>
          <p>At <span>My Library</span>, we're your gateway to a world of literature and knowledge. Dive into our extensive collection of books, where every page holds the potential for adventure, learning, and escape. Whether you're seeking fiction, non-fiction, or something in between, our shelves are stocked with stories waiting to be discovered. Come explore, borrow, and embark on new literary journeys with us.</p>
        </div>
      <div class="bottom">
        <div class="container mx-auto row">
          <div class="row col" id="users" onmouseenter="hoverAchievements(this)" onmouseleave="outAchievements(this);">
              <div class="col img">
                <img src="images/users_color.png" class="rounded float-left" alt="...">
              </div>
              <div class="col achievement">
                <p class="number" id="numberUsers">0</p>
                <p class="label">Users</p>
              </div>
            </div>
          <div class="row col" id="books" onmouseenter="hoverAchievements(this)" onmouseleave="outAchievements(this);" >
              <div class="col img">
                <img src="images/books_color.png" class="rounded float-left" alt="...">
              </div>
              <div class="col achievement">
                <p class="number" id="numberBooks">0</p>
                <p class="label">Books</p>
              </div>
          </div>
          <div class="row col" id="categories" onmouseenter="hoverAchievements(this)" onmouseleave="outAchievements(this);">
            <div class="col img">
              <img src="images/category_color.png" class="rounded float-left" alt="...">
            </div>
            <div class="col achievement">
              <p class="number" id="numberCategory">0</p>
              <p class="label">Categories</p>
            </div>
          </div>
          <div class="row col" id="reviews" onmouseenter="hoverAchievements(this)" onmouseleave="outAchievements(this);">
            <div class="col img">
              <img src="images/reviews_color.png" class="rounded float-left" alt="...">
            </div>
            <div class="col achievement">
              <p class="number" id="numberReviews">0</p>
              <p class="label">Reviews</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="DisplayAllBooks">
      <div class="latest" style="padding-top:60px">
        <div class="latest-release container">
          <h1 class="latest-h1">Latest Releases</h1>
          <div class="see-more">
            <a href="books.php?p=1&selection=latestRelease" class="btn btn-dark">See more</a>
          </div>
          <div class="mx-auto row col-12 p-5 books">
            <?php foreach($latestReleases as $newBook): ?>
              <div class="col-3 p-2">
                <div class="card product" style="width: 16rem; border-radius: 20px" title="<?= $newBook["BookTitle"]; ?>">
                  <img src="<?= $newBook['Image-URL-L']; ?>" class="card-img-top" alt="<?= $newBook["BookTitle"]; ?>" width="100" height="300">
                  <div class="card-body">
                    <h5 class="card-title title"><?= $newBook['BookTitle']; ?></h5>
                    <p class="card-text"><?= round($newBook['Price'], 2); ?>$</p>
                    <a href="produit.php?isbn=<?= $newBook["ISBN"]; ?>" class="btn btn-dark">Read Details</a>
                    <?php if($newBook["stock"] > 0): ?>
                      <span class="text-success m-3">Available</span>
                    <?php else: ?>
                      <p class="text-danger m-4">Out of stock</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

  <div onmouseenter="line(this);" class="between">
    <div class="line"><div style="display: none;">first time</div></div>

  </div>
  
  <div class="latest">
    
    <div class="topRatedBooks container">
      <h1 class="latest-h1">Top Rated Books</h1>
      <div class="see-more"><a href="books.php?p=1&selection=topRated" class="btn btn-dark">See more</a></div>
      <div class="row col-12 mx-auto bigCard" style="margin: 0px;">
      <div class="row col-8 bigTemplate" style="padding: 0px;margin:0px;height:700px">
          <div class="card text-white p-0 text-left parent-description"  style="overflow: hidden;background-color:black;">
            <img class="card-img" id="imgTemplate" src=<?php echo $topRated[0]["Image-URL-L"] ?> alt="Card image" style="height: 700px !important; width: 100% !important;">
            <div class="card-img-overlay p-0">
              <p class="card-text text-white bg-success bigCard-price" id="priceTemplate"><?php echo round($topRated[0]['Price'],2) ?> $</p>
  
              <div class="bigCard-description" id="divTitleTemplate" Title="<?php echo $topRated[0]["BookTitle"] ?>">
  
                <h5 class="card-title title" id="titleTemplate" style="height:80px; -webkit-line-clamp: 1 !important;"><?php echo $topRated[0]["BookTitle"]?></h5>
                
                <p class="card-text" id="authorTemplate" >Author: <?php echo $topRated[0]["BookAuthor"] ?> </p>
                <p class="card-text" id="categoryTemplate">Category: <?php echo $topRated[0]["categories"] ?></p>
                <a href="produit.php?isbn=<?php echo $topRated[0]["ISBN"]?>" class="btn btn-danger" id="show-details">Read Details</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-4 ">
          <?php
          $i=0;
          foreach($topRated as $topBook): ?>
            
            <div class="card mb-3 card p-0 m-2 cardTopBooks" style="max-width: 540px; height:150px; overflow: hidden; cursor: pointer;" Title="<?= $topBook["BookTitle"]?>"">
            <div  class="row g-0 topBook" onclick="selectedTopRated(this);" id=topBook<?=$i++?> >
              <div class="col-md-4 img">
                <img src="<?=$topBook['Image-URL-L']?>" class="img-fluid rounded-start" alt="<?= $topBook["BookTitle"]?>" style="height: 150px; width:135px;">
              </div> 
              <div class="col-md-8">
                <div class="card-body topRated-d-right">
                  <h5 class="card-title title"><?= $topBook["BookTitle"]?></h5>
                  <p class="card-text">Author: <?= $topBook["BookAuthor"]?></p>
                  <p class="card-text">Category: <?= $topBook["categories"]?></p>
                  <p class="card-text text-success price"><?= round($topBook['Price'],2) ?>$</p>
                  <span hidden><?= $topBook["ISBN"] ?></span>
                </div>
              </div>
            </div>
          </div>
          
          
          <?php endforeach;?>
  
  
  
        </div>
      </div> 
    </div>
        
  </div>
  
  
  
  <div onmouseenter="line(this);" class="between">
    <div class="line"><div style="display: none;">first time</div></div>
  </div>
  <div class="latest">
    <div class="mostSold container">
      <h1 class="latest-h1">Most Sold Books</h1>
      <div class="see-more"><a href="books.php?p=1&selection=mostSold" class="btn btn-dark">See more</a></div>
      <div class="mx-auto row col-12 p-5 books" >
        <?php 
        foreach($mostSold as $MostSoldBook):  #for x in liste ?>
                
          <div class="col-3 p-2">
          <div class="card product" style="width: 16rem;border-radius:20px" title="<?= $MostSoldBook["BookTitle"] ?>">
              <img src="<?= $MostSoldBook['Image-URL-L']?>" class="card-img-top" alt="<?= $MostSoldBook["BookTitle"]?>" width="100" height="300">
              <div class="card-body">
                <h5 class="card-title title" ><?= $MostSoldBook['BookTitle']?></h5>
                <p class="card-text"><?= round($MostSoldBook['Price'],2)?>$</p>
                <a href="produit.php?isbn=<?=$MostSoldBook["ISBN"]?>" class="btn btn-dark">Read Details</a>
                <?php if($MostSoldBook["stock"] > 0):?>
                  
                      <span class="text-success m-3">Available</span>
                      </div>
                      </div>
                    </div>
                <?php else: ?>
                  
                      <p class="text-danger m-4">out of stock</p>
                      </div>
                      </div>
                    </div> 
                <?php endif; ?>
        
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <div onmouseenter="line(this);" class="between" style="margin-bottom: 0px;">
  <div class="line"><div style="display:none;">first time</div></div>
  </div>

  
</div>  









      
      
      <!-- products 
      <div class="container mx-auto row col-12 p-5 books">
        <?php 
        foreach($books as $book){  #for x in liste
          print '        
          <div class="col-3 p-2">
          <div class="card product" style="width: 16rem;border-radius:20px" title="'.$book["BookTitle"] .'">
              <img src="'.$book['Image-URL-L'].'" class="card-img-top" alt="'.$book["BookTitle"].'" width="100" height="300">
              <div class="card-body">
                <h5 class="card-title title" >'.$book['BookTitle'].'</h5>
                <p class="card-text">'.round($book['Price'],2).'$</p>
                <a href="produit.php?isbn='.$book["ISBN"].'" class="btn btn-dark">Read Details</a>';
                if($book["stock"] > 0){
                  print '
                      <span class="text-success m-3">Available</span>
                      </div>
                      </div>
                    </div> ';
                }else{
                  print '
                      <p class="text-danger m-4">out of stock</p>
                      </div>
                      </div>
                    </div> ';
                }

          }


        ?>

 
      </div>

        -->
      <!-- Footer -->
</body>
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