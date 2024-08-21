<!--php--> 
<?php // session_start() ?>

<!-- html -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="sessionIndex/clear.php">My Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
              </a>
              <ul class="dropdown-menu categories" style="height:600px;overflow:auto">
                <?php
                foreach($categories as $category):?>
                  <li><a class="dropdown-item" href="books.php?p=1&selection=latestRelease&name=<?= $category["categoryNAME"]?>"><?= $category['categoryNAME']?></a></li>
              
                <?php endforeach;?>
              </ul>
            </li>
            
            <!-- custom navbar if connected --> 

            <?php 
            //if connected
            
            if(isset($_SESSION["Connexion"])):?>
              print'
                <li class="nav-item">
                  <a href="profile.php" class="nav-link active" aria-current="page" >Profile</a>
                </li>
              
              ';
            <?php else: ?>
              
                  <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Connect
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="connection.php">Sign in</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="register.php">Create an account</a></li>
                  </ul>
                </li>
              
              
            
            <?php endif; ?>


          </ul>
          <form class="d-flex" action="action/search.php" method="POST">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-danger" type="submit">Search</button>
          </form>
          <?php
          if(isset($_SESSION["firstName"])):?>
            
            <a href="disconnect.php" class="btn btn-primary"> Disconnect </a>

            
          
          <?php endif;?>
        </div>
      </div>
  </nav>