<?php

//connect 

use function Laravel\Prompts\select;

function connect(){

    // 1 - connect to DB
    $servername = "localhost";
    $username = "root";
    $password = "";
    $myDB = "bibliotheque";
    
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    return $conn;
}

//Get All categories inside an array
function getCategories(){
  //connect
  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM categories";

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $categories = $result->fetchAll(); 

  return $categories;
}



//Get All books inside an array
function getBooks(){

    $conn = connect();

    // 2- request creation
    
    $request = "SELECT * FROM books order by PublishYear desc, PublishMonth desc, PublishDay desc";

    // 3-  request execution
    
    $result = $conn->query($request);
    // request result 
    
    $books = $result->fetchAll(); 

    return $books;
}


//Get All books inside an array
function getBooksBySelection($selection){

  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM books order by ".$selection;

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $books = $result->fetchAll(); 

  return $books;
}


function getLibrarians(){

  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM librarian";

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $librarians = $result->fetchAll(); 

  return $librarians;
}

function getCustomer(){

  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM users";

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $customers = $result->fetchAll(); 

  return $customers;
}



// search for a book Title

function search($name){
  $conn = connect();

  //request
  $request = "SELECT * From books where BookTitle like '%$name%' ";

  //execute
  $result = $conn->query($request);

  //result
  $books = $result->fetchAll();

  return $books;

}

function searchCategory($name){
  $conn = connect();

  //request
  $request = "SELECT * From categories where categoryNAME like '%$name%' ";

  //execute
  $result = $conn->query($request);

  //result
  $categories = $result->fetchAll();

  return $categories;

}

function findCategory($category){
  $conn = connect();

  //request
  $request = "SELECT * From books where categories = '$category' ";

  //execute
  $result = $conn->query($request);

  //result
  $books = $result->fetchAll();

  return $books;

}



function searchWithCategory($name,$category){
  $conn = connect();

  //request
  $request = "SELECT * From books where BookTitle like '%$name%' and categories ='$category' ";

  //execute
  $result = $conn->query($request);

  //result
  $books = $result->fetchAll();

  return $books;

}


function searchLibrarians($name){
  $conn = connect();

  //request
  $request = "SELECT * From librarian where `Email` like '%$name%' ";

  //execute
  $result = $conn->query($request);

  //result
  $librarian = $result->fetchAll();

  return $librarian;
}


function searchCustomers($name){
  $conn = connect();

  //request
  $request = "SELECT *  From users where `Email` like '%$name%'";

  //execute
  $result = $conn->query($request);

  //result
  $customers = $result->fetchAll();

  return $customers;
}





// display Book's details 

function getBookById($id){
  $conn = connect();
  //request creation
  $request = "SELECT * FROM books where ISBN = '$id'";
  //execute
  $result = $conn->query($request);
  //result
  $book = $result->fetch();

  return $book;
}



//detect_face_for register
function faceDetection($base64Image){
  $file = "encodedImage.base64";
  $fp = fopen($file,"wb");
  fwrite($fp,$base64Image);
  fclose($fp);

  $command = escapeshellcmd(command: "python ./myPython/find_face.py ".$file."");
  exec($command,$output,$result_code);

  //var_dump($output);
  if($output[0] == "True"){
    return true;
  }else if ($output[0] == 'False'){
    return false;
  }
}




//add new user from register
function addUser($data){
  $folderPath = 'DataBaseImages/UserImage/';

  $conn = connect();

  //hash password
  $hashPWD = md5($data["PWD"]);

  //Request creation
  if($data["chooseImage"] == "camera"){
    try{
      //save image 
      $image_parts = explode(";base64,", $data["captured_image_data"]);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $file = $folderPath . uniqid() . '.png';

      //face verification
      $find_face = faceDetection($image_parts[1]);

      if($find_face){
        //save in SQL
        $request = "INSERT INTO users(Email,PWD,firstName,lastName,userImage,`Address`,Country,City,Zip) VALUES('".$data['Email']."','".$hashPWD."','".$data['firstName']."','".$data['lastName']."','".$file."','".$data['Address']."','".$data['Country']."','".$data['City']."','".$data['Zip']."')";
        $result = $conn->query($request);
        //save in folder
        file_put_contents($file, $image_base64);
      }else{
        header("location:register.php?error=noFace");
        return false;
        exit;
      }

      return true;

    }catch(PDOException $e){
      header("location:register.php?error=duplicated");
    }
  }else{
    //save image
    //print_r($_FILES);
    try{
      // Get image name
      $image = $_FILES['uploaded_image_data']['name'];
  
      // image file directory
      $target = $folderPath.basename($image);

      ####
      //(convert image base64)
      $image_tmp_name = $_FILES['uploaded_image_data']['tmp_name'];
      $imagedata = file_get_contents($image_tmp_name);
      $base64_image = base64_encode($imagedata);  

      //face verification
      $find_face = faceDetection($base64_image);

      if($find_face){
        //save in SQL
        $request = "INSERT INTO users(Email,PWD,firstName,lastName,userImage,`Address`,Country,City,Zip) VALUES('".$data['Email']."','".$hashPWD."','".$data['firstName']."','".$data['lastName']."','".$target."','".$data['Address']."','".$data['Country']."','".$data['City']."','".$data['Zip']."')";
        $result = $conn->query($request);
        //save image 
        move_uploaded_file($_FILES['uploaded_image_data']['tmp_name'], $target);
      }else{
        header("location:register.php?error=noFace");
        return false;
        exit;
      }

      return true;
      
    }catch(PDOException $e){
      header("location:register.php?error=duplicated");
    }

  }
  //request execution 

  /*/verification
  if($result){
    return true;
  }else{
    return false;
  }*/
}

function userConnection($data){
  $conn = connect();

  $hashPWD = md5($data["PWD"]);
  $email = $data['Email'];

  $request = "SELECT * FROM users WHERE Email='$email' AND PWD='$hashPWD'";
  $result = $conn->query($request);
  
  $user = $result->fetch();
  return $user;
}

function userConnectionLevel1($data){
  $conn = connect();

  $hashPWD = md5($data["PWD"]);
  $email = $data['Email'];

  $request = "SELECT * FROM users WHERE Email='$email' AND PWD='$hashPWD'";
  $result = $conn->query($request);
  
  $user = $result->fetch();
  return $user;
}


//face recognition to connect=============================================================================================
function verifyUserFaceSaveImage($base64Image,$realImagePath,$userId){
  $file = "encodedImage.base64";
  $fp = fopen($file,"wb");
  fwrite($fp,$base64Image);
  fclose($fp);

  //$userFace = $data["userImage"];

  $command = escapeshellcmd(command: "python ./myPython/reconnect_user.py ".$file." ".$realImagePath);
  exec($command,$output,$result_code);
  //echo "br";
  //var_dump($output);

  //var_dump($output);
  if($output[0] == "True"){
    return true;
  }else if ($output[0] == 'False'){
    //save image 
    $folderPath = 'DataBaseImages/failAttempting/id'.$userId."/";
    // Check if the folder doesn't exist
    //echo" oooooooooooooooooooooooooooooooooooooooooooooooo";
    if (!file_exists($folderPath)) {
      // Create the folder
      //echo "eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee<br>aaaaaaaaaaaaaaaaaaaaaa";
      mkdir($folderPath, 0777, true); // The third parameter `true` creates nested directories if necessary (-p fel linux)
    }

    /*$image_parts = explode(";base64,", $data["captured_image_data"]);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);*/
    $file = $folderPath . uniqid() . '.png';
    $base64_ready_to_save = base64_decode($base64Image);

    file_put_contents($file, $base64_ready_to_save);

    return false;
  }
}


//face recognition to connect
function verifyUserFace($base64Image,$realImagePath){
  $file = "encodedImage.base64";
  $fp = fopen($file,"wb");
  fwrite($fp,$base64Image);
  fclose($fp);

  //$userFace = $data["userImage"];

  $command = escapeshellcmd(command: "python ./myPython/reconnect_user.py ".$file." ".$realImagePath);
  exec($command,$output,$result_code);
  //echo "br";
  //var_dump($output);

  //var_dump($output);
  if($output[0] == "True"){
    return true;
  }else if ($output[0] == 'False'){
    return false;
  }
}


function userConnectionLevel2($realImagePath,$captured_image){

  //get user image from base 64
  $image_parts = explode(";base64,", $captured_image);
  //echo "<br> heeeeee <br>";
  //var_dump($realImagePath);

  //compare with the real user
  $find_face = verifyUserFace($image_parts[1],$realImagePath);
  //var_dump($find_face);
  

  return $find_face;
}

function userConnectionLevel2_v2($realImagePath,$captured_image,$userId){

  //get user image from base 64
  $image_parts = explode(";base64,", $captured_image);
  //echo "<br> heeeeee <br>";
  //var_dump($realImagePath);

  //compare with the real user
  //$find_face = verifyUserFace($image_parts[1],$realImagePath);
  $find_face = verifyUserFaceSaveImage($image_parts[1],$realImagePath,$userId);
  //var_dump($find_face);
  

  return $find_face;
}


function librarianConnection($data){
  $conn = connect();

  $hashPWD = md5($data["PWD"]);
  $email = $data['Email'];

  $request = "SELECT * FROM librarian WHERE Email='$email' AND PWD='$hashPWD'";
  $result = $conn->query($request);
  
  $librarian = $result->fetch();
  return $librarian;

}
function adminConnection($data){
  $conn = connect();

  $hashPWD = md5($data["PWD"]);
  $email = $data['Email'];

  $request = "SELECT * FROM `admin` WHERE Email='$email' AND PWD='$hashPWD'";
  $result = $conn->query($request);
  
  $admin = $result->fetch();
  return $admin;

}


//get Retardataire

function getLateReturns($date){
  $conn = connect();
  $request="SELECT * , DATEDIFF('$date',e.DateE) as numberOfDays FROM users u,emprunt e ,books b WHERE u.ID = e.userID and b.ISBN = e.bookID and DATEDIFF('$date',e.DateE) > 10 AND returned='no'
  order by numberOfDays desc";
  $result = $conn->query($request);
  $lateReturners = $result->fetchAll();
  return $lateReturners;
}


function getLateReturners(){
  $conn = connect();
  //$request="SELECT * FROM users u,emprunt e ,books b WHERE u.ID = e.userID and b.ISBN = e.bookID and DATEDIFF('$date',e.DateE) > 10 AND returned='no'";
  $request="SELECT * FROM users u, ( SELECT userId, ROUND(AVG(DATEDIFF(CURRENT_DATE(), DateE))) AS numberOfDays FROM emprunt WHERE returned = 'no' GROUP BY userId) as e 
            WHERE u.Id = e.userID
            ORDER BY e.numberOfDays desc";
            
  
  $result = $conn->query($request);
  $lateReturners = $result->fetchAll();
  return $lateReturners;
}






function getSuspended(){
  $conn = connect();
  $request="SELECT * FROM users WHERE Statut = 'suspended'";
  $result = $conn->query($request);
  $suspended = $result->fetchAll();
  return $suspended;
}
//get all the Transactions

function getTransactions($date){
  $conn = connect();
  $request="SELECT * , DATEDIFF('$date',e.DateE) as numberOfDays FROM users u,emprunt e, books b WHERE u.ID = e.userID and e.bookID = b.ISBN order by e.dateE desc";
  $result = $conn->query($request);
  $Transactions = $result->fetchAll();
  return $Transactions;
}

function searchCustomerTrunsactions($name){
  $conn = connect();

  //request
  $request = "SELECT * , DATEDIFF(CURRENT_DATE(),e.dateE) as numberOfDays From users u, emprunt e, books b WHERE u.ID = e.userID and e.bookID = b.ISBN and u.Email like '%$name%' order by numberOfDays";

  //execute
  $result = $conn->query($request);

  //result
  $customers = $result->fetchAll();

  return $customers;
}

function getUnreturnedTransactions($date){
  $conn = connect();
  $request="SELECT * , DATEDIFF('$date',DateE) AS numberOfDays FROM users u,emprunt e,books b WHERE u.ID = e.userID and e.bookID = b.ISBN and e.returned = 'no' order by numberOfDays desc";
  $result = $conn->query($request);
  $transactions = $result->fetchAll();
  return $transactions;
}

function getQuotes(){
  $conn = connect();
  $request= "SELECT * from quotes where length(Quote) < 250";
  $result = $conn->query($request);
  $quotes = $result->fetchAll();
  return $quotes;
}

function getCountries(){
  $conn = connect();
  $request= "SELECT * from countries";
  $result = $conn->query($request);
  $countries = $result->fetchAll();
  return $countries;
}



function getLatestReleases(){
  $conn = connect();
  $request="SELECT * FROM books ORDER BY PublishYear desc,PublishMonth desc,PublishDay DESC LIMIT 4";
  $result=$conn->query($request);
  $latestRelease=$result->fetchAll();
  return $latestRelease;
}

function getMostRead(){
  $conn = connect();
  $request="SELECT books.* FROM books, (SELECT bookID ,COUNT(*) AS sells FROM emprunt GROUP BY bookID ORDER BY COUNT(*) DESC) AS t WHERE t.bookID = books.ISBN ORDER BY t.sells DESC LIMIT 4";
  $result=$conn->query($request);
  $mostRead=$result->fetchAll();
  return $mostRead;
}

function getTopRated(){
  $conn = connect();
  $request="SELECT * FROM books ORDER BY rating DESC LIMIT 4;";
  $result=$conn->query($request);
  $topRated=$result->fetchAll();
  return $topRated;
}


//Get All authors inside an array
function getAuthors(){
  //connect
  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM authors";

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $authors = $result->fetchAll(); 

  return $authors;
}


//Get All publishers inside an array
function getPublishers(){
  //connect
  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM publishers";

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $publishers = $result->fetchAll(); 

  return $publishers;
}

function getPublishYear(){
    //connect
    $conn = connect();

    // 2- request creation
    
    $request = "SELECT DISTINCT PublishYear FROM books WHERE PublishYear <>0 ORDER BY PublishYear desc";
  
    // 3-  request execution
    
    $result = $conn->query($request);
    // request result 
    
    $publishYear = $result->fetchAll(); 
  
    return $publishYear;
}

function getBooksByRequest($request){
      //connect
      $conn = connect();
    
      // 2-  request execution
      
      $result = $conn->query($request);
      // request result 
      
      $books = $result->fetchAll(); 
      return $books;
}


function createRequest($get,$selection){
      //create the request
    //$request = "SELECT * FROM books";
    $request ="SELECT *, ROW_NUMBER() OVER(ORDER BY ".$selection." ) RowNumber FROM books";
    //initialise parts 
    $authorRequest="";
    $categoryRequest="";
    $publisherRequest="";
    $yearRequest="";
    $titleRequest="";
    $priceRequest= " WHERE Price >= ".$get["minPrice"]." AND Price <= ".$get["maxPrice"]."+1 ";
    $rateRequest=" AND Rating >= ".$get["minRate"]." AND Rating <= ".$get["maxRate"]."+1 ";
    
    //rebuild request 
    $request = $request.$priceRequest.$rateRequest;
    //check if forms are filled
    if($get['category'] !="Category"){
        $categoryRequest = " AND categories = '".$get["category"]."'";
    }
    if($get['author'] !="Author"){
        $authorRequest = " AND BookAuthor = '".$get["author"]."'";
    }
    if($get['publisher'] !="Publisher"){
        $publisherRequest = " AND Publisher = '".$get["publisher"]."'";
    }
    if($get['year'] !="Publisher Year"){
        $yearRequest = " AND PublishYear =".$get["year"];
    }
    if(isset($get['bookTitle'])){
        $titleRequest = " AND BookTitle like '%".$get["bookTitle"]."%'";
    }

    $request = $request.$authorRequest.$categoryRequest.$publisherRequest.$yearRequest.$titleRequest;
    return $request;
}

// à optimiser ( she can be mixed with the normal createRequest )



function createRequest2($get){
      //create the request
    //$request = "SELECT * FROM books";
    $request = "SELECT *,COALESCE(qtSales,0) AS salesQuantity ,ROW_NUMBER() OVER(ORDER BY qtSales desc) rowNumber FROM books 
    LEFT JOIN (
    SELECT bookID, COUNT(*) AS qtSales
    FROM emprunt
    GROUP BY bookID 
    ) AS soldBooks ON books.ISBN = soldBooks.bookID
";    



    //initialise parts 
    $authorRequest="";
    $categoryRequest="";
    $publisherRequest="";
    $yearRequest="";
    $titleRequest="";
    $priceRequest= " WHERE Price >= ".$get["minPrice"]." AND Price <= ".$get["maxPrice"];
    $rateRequest=" AND Rating >= ".$get["minRate"]." AND Rating <= ".$get["maxRate"];
    
    //rebuild request 
    $request = $request.$priceRequest.$rateRequest;
    //check if forms are filled
    if($get['category'] !="Category"){
        $categoryRequest = " AND categories = '".$get["category"]."'";
    }
    if($get['author'] !="Author"){
        $authorRequest = " AND BookAuthor = '".$get["author"]."'";
    }
    if($get['publisher'] !="Publisher"){
        $publisherRequest = " AND Publisher = '".$get["publisher"]."'";
    }
    if($get['year'] !="Publisher Year"){
        $yearRequest = " AND PublishYear =".$get["year"];
    }
    if(isset($get['bookTitle'])){
        $titleRequest = " AND BookTitle like '%".$get["bookTitle"]."%'";
    }

    $request = $request.$authorRequest.$categoryRequest.$publisherRequest.$yearRequest.$titleRequest;
    return $request;
}










function getBooksBySales(){
  $conn = connect();
  $request = "SELECT *,COALESCE(qtSales,0) AS salesQuantity ,ROW_NUMBER() OVER(ORDER BY qtSales desc) rowNumber FROM books 
              LEFT JOIN (
              SELECT bookID, COUNT(*) AS qtSales
              FROM emprunt
              GROUP BY bookID 
              ) AS soldBooks ON books.ISBN = soldBooks.bookID;
  ";

  $result = $conn->query($request);
  $books = $result->fetchAll();
  return $books;
}






function getBooksByPage($sampleSize,$startIndex,$request){ //limit , offset
      //
      $conn = connect();
      $request = "SELECT * FROM (".$request.") AS table1 LIMIT ".$sampleSize." OFFSET ".$startIndex."";
      $result = $conn->query($request);
      $books = $result->fetchAll();
      return $books;
}


function getBooksBySalesPage($sampleSize,$startIndex){
  $conn = connect();

  $table1 = "SELECT *,COALESCE(qtSales,0) AS salesQuantity ,ROW_NUMBER() OVER(ORDER BY qtSales desc) rowNumber FROM books 
              LEFT JOIN (
              SELECT bookID, COUNT(*) AS qtSales
              FROM emprunt
              GROUP BY bookID 
              ) AS soldBooks ON books.ISBN = soldBooks.bookID
  ";
  $request = "SELECT * FROM (".$table1.") AS table1 LIMIT ".$sampleSize." OFFSET ".$startIndex."";


  $result = $conn->query($request);
  $books = $result->fetchAll();
  return $books; 
}

function getBooksBySelectionPage($sampleSize,$startIndex,$selection,$title){

  $conn = connect();

  // 2- request creation
  
  $table1 = "SELECT * FROM books WHERE BookTitle LIKE '%$title%' order by ".$selection."";

  $request = "SELECT * FROM (".$table1.") AS table1 LIMIT ".$sampleSize." OFFSET ".$startIndex."";


  // 3-  request execution*
  
  $result = $conn->query($request);
  // request result 
  
  $books = $result->fetchAll(); 

  return $books;
}
function getBooksBySelectionPageCategory($sampleSize,$startIndex,$selection,$category){

  $conn = connect();

  // 2- request creation
  
  $table1 = "SELECT * FROM books WHERE categories LIKE '%$category%' order by ".$selection."";

  $request = "SELECT * FROM (".$table1.") AS table1 LIMIT ".$sampleSize." OFFSET ".$startIndex."";


  // 3-  request execution*
  
  $result = $conn->query($request);
  // request result 
  
  $books = $result->fetchAll(); 

  return $books;
}





function getNumberOfPages($request){
  //connect
  $conn = connect();

  // 1 request
  $table = "SELECT count(*) FROM (".$request.") AS TABLE1";

  // 2-  request execution
  
  $result = $conn->query($table);
  // request result 
  
  $number = $result->fetch(); 

  return $number;
}

function getNumberOfPagesBySales(){
  $conn = connect();
  $request = "SELECT *,COALESCE(qtSales,0) AS salesQuantity ,ROW_NUMBER() OVER(ORDER BY qtSales desc) rowNumber FROM books 
              LEFT JOIN (
              SELECT bookID, COUNT(*) AS qtSales
              FROM emprunt
              GROUP BY bookID 
              ) AS soldBooks ON books.ISBN = soldBooks.bookID
  ";
  
  $table = "SELECT count(*) FROM (".$request.")  AS TABLE1";


  $result = $conn->query($table);
  $number = $result->fetch();
  return $number;
}




//Get All books inside an array
function getNumberOfPagesBySelection($selection){

  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM books order by ".$selection;

  // 3-  request execution
  
  $table = "SELECT count(*) FROM (".$request.")  AS TABLE1";


  $result = $conn->query($table);
  $number = $result->fetch();
  return $number;
}



function showMessages($targetId){
  $conn = connect();
  $request ="SELECT * FROM messages WHERE senderId = $targetId or receiverId = $targetId";
  $result = $conn->query($request);
  $messages = $result->fetchAll();
  return $messages;
}

function getLibrarianById($id){
  $conn = connect();
  $request ="SELECT * FROM librarian WHERE Id = $id";
  $result = $conn->query($request);
  $librarian = $result->fetch();
  return $librarian;
}

function getAllUserId(){
  $conn = connect();
  $request = "SELECT Id FROM users";
  $result = $conn->query($request);
  $allId = $result->fetchAll();
  return $allId;
}

function getAllConversations(){
  $array = array();
  $allId = getAllUserId();
  foreach($allId as $id){
    $array[$id['Id']] = showMessages($id['Id']);
  }
  return $array;
}


function getUserById($id){

  $conn = connect();

  // 2- request creation
  
  $request = "SELECT * FROM users WHERE Id = '$id'";

  // 3-  request execution
  
  $result = $conn->query($request);
  // request result 
  
  $user = $result->fetch(); 

  return $user;
}



?>


