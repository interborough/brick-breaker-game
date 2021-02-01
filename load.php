<?php

session_start();
//PERSONAL DATABASE INFO REMOVED
$db = mysqli_connect('hostname', 'username', 'password', 'schema') or die("Could not connect to database");

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
}
else
{
    //User is not logged in.
    mysqli_close($db);
    echo "Please login to load from the database.";
}

?>