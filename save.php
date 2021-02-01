<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Save Game to Database</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
session_start();
//PERSONAL DATABASE INFO REMOVED
$db = mysqli_connect('hostname', 'username', 'password', 'schema') or die("Could not connect to database");
$saveGame = $_POST['gamestate'];

$currScore = $saveGame['currScore']; 
$currLives = $saveGame['currLives']; 
$paddlePos = $saveGame['paddlePos']; 
$ballXPos = $saveGame['ballXPos']; 
$ballYPos = $saveGame['ballYPos']; 
$ballxDist = $saveGame['ballxDist']; 
$ballYDist = $saveGame['ballYDist']; 
$blockArray = json_encode($saveGame['blockArray']); 
 
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username']; 

    //Check if user is in database
    $search_query = "SELECT username FROM saves WHERE username = '$username'"; 
    $search_results = mysqli_query($db, $search_query);
    
    if(mysqli_num_rows($search_results))
    {
        //User already in database, update save. 
        $update_query = "UPDATE saves SET score = '$currScore', lives = '$currLives', paddle = '$paddlePos', ballx = '$ballXPos', bally = '$ballYPos', ballxdist = '$ballxDist', ballydist = '$ballYDist', blocks = '$blockArray' WHERE username = '$username'"; 
        $update_results = mysqli_query($db, $update_query);
    }
    else
    {
        //User not in database, create save.
        $insert_query = "INSERT INTO saves (username, score, lives, paddle, ballx, bally, ballxdist, ballydist, blocks) VALUES ('$username', '$currScore', '$currLives', '$paddlePos', '$ballXPos', '$ballYPos', '$ballxDist', '$ballYDist', '$blockArray')";  
        $insert_results = mysqli_query($db, $insert_query);
    }

    echo("Save successful!");
    mysqli_close($db);
    header("refresh:3; url=index.html");
}
else
{
    //User is not logged in.
    mysqli_close($db);
    echo("Please login to save to the database. Redirecting in 3 seconds..."); 
    header("refresh:3; url=index.html"); 
}

?>
</body>
</html>