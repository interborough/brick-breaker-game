<?php

session_start();

//Note: Database information removed for Github.
$server_hostname = "";
$server_username = "";
$server_password = "";
$server_dbname = "";

$db = mysqli_connect($server_hostname, $server_username, $server_password, $server_dbname) or die ("Could not connect to database.");

if(isset($_SESSION['username']))
{
    $username = $_SESSION['username']; 

    $load_query = "SELECT * FROM saves WHERE username = '$username' LIMIT 1";   
    $load_results = mysqli_query($db, $load_query);
    $array = mysqli_fetch_assoc($load_results);

    $score = $array["score"]; 
    $lives = $array["lives"]; 
    $paddle = $array["paddle"]; 
    $ballx = $array["ballx"]; 
    $bally = $array["bally"];
    $ballxdist = $array["ballxdist"]; 
    $ballydist = $array['ballydist']; 
    $blocks = json_decode($array["blocks"]); 

    $data = ['score' => $score, 'lives' => $lives, 'paddle' => $paddle, 'ballx' => $ballx, 'bally' => $bally, 'ballxdist' => $ballxdist, 'ballydist' => $ballydist, 'blocks' => $blocks];  

    mysqli_close($db);
    echo json_encode($data);
}
else
{
    //User is not logged in.
    mysqli_close($db);
    echo "Please login to load from the database.";
}

?>