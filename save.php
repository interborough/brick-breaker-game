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
    $search_query = "SELECT username FROM saves WHERE username = ?";
    $stmt = $db->prepare($search_query); 
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = $result->fetch_assoc();

    if($array) 
    {
        //User already in database, update save.
        $update_query = "UPDATE saves SET score = ?, lives = ?, paddle = ?, ballx = ?, bally = ?, ballxdist = ?, ballydist = ?, blocks = ? WHERE username = ?"; 
        $stmt = $db->prepare($update_query); 
        $stmt->bind_param("iidddddss", $currScore, $currLives, $paddlePos, $ballXPos, $ballYPos, $ballxDist, $ballYDist, $blockArray, $username);
        $stmt->execute();
    }
    else 
    {
        //User not in database, create save.
        $insert_query = "INSERT INTO saves (username, score, lives, paddle, ballx, bally, ballxdist, ballydist, blocks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
        $stmt = $db->prepare($insert_query); 
        $stmt->bind_param("siiddddds", $username, $currScore, $currLives, $paddlePos, $ballXPos, $ballYPos, $ballxDist, $ballYDist, $blockArray);
        $stmt->execute();
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
