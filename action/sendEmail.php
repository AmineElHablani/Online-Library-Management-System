<?php

include "../include/functions.php";

//get the user
$userId = $_GET["idUser"];
$user = getUserById($userId);


//Email (destination)
$to = $user["Email"];
echo $to;

//object 
$object = "SecureAlert: Suspicious Login Attempts Detected";


//get location
// Get user's IP address
$userIP = $_SERVER['REMOTE_ADDR'];

// Call an IP geolocation service or API
// Example using freegeoip.app
$geoData = json_decode(file_get_contents("https://freegeoip.app/json/{$userIP}"));

// Extract location information
$country = $geoData->country_name;
$region = $geoData->region_name;
$city = $geoData->city;


// Construct the email headers
$headers = "From aminehableni1898@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

// Construct the email message
$message = "--boundary\r\n";
$message .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

//email message 
$date = date("Y-m-d H:i:s");
$message .= "<p>Dear [User]<br><br>
We have detected a suspicious login attempt on your account..</p>
<p>**Details:**<br>
- Date & Time: [Date/Time] <br>
- Location: [Location] <br>
- Device: [Device Information] <br>
</p>
\r\n";


/// Get User images (attempts)
$imageDirectory = '../DataBaseImages/failAttempting/id'.$userId."/";

$images = scandir($imageDirectory);


// Loop through each image
foreach ($images as $image) {
    // Checking if its is an image
    if (pathinfo($image, PATHINFO_EXTENSION) === "png") {
        // Read the image data
        $imageData = file_get_contents($imageDirectory . $image);
        
        // Encode the image data into base64
        $encodedImageData = base64_encode($imageData);

        // Add the image as an attachment
        $message .= "--boundary\r\n";
        $message .= "Content-Type: image/png; name=\"" . $image . "\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"" . $image . "\"\r\n\r\n";
        $message .= chunk_split($encodedImageData) . "\r\n";
    }
}

// Close the message boundary
$message .= "--boundary--\r\n";



// Send the email
// $mailResult = mail($to, $object, $message, $headers);


// Get the current time
echo "<br>";
$current_time = time();

// Calculate the time 30 minutes from now
$next_30_minutes = strtotime('+90 minutes', $current_time); //3andna 1h retard
echo $next_30_minutes;

// Format the time for display or storage, if needed
$formatted_next_30_minutes = date('Y-m-d H:i:s', $next_30_minutes);


// Check if the email was sent successfully
if ($mailResult) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}
?>