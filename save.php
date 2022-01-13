<?php
session_start();

//Note: Database information removed for Github.
$server_hostname = "";
$server_username = "";
$server_password = "";
$server_dbname = "";

$db = mysqli_connect($server_hostname, $server_username, $server_password, $server_dbname) or die ("Could not connect to database.");

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

    mysqli_close($db);
    echo "Save Successful!";
}
else
{
    //User is not logged in.
    mysqli_close($db);
    echo "Please login to save to the database.";
}

?>
