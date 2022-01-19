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

    $load_query = "SELECT * FROM saves WHERE username = ? LIMIT 1";
    $stmt = $db->prepare($load_query); 
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = $result->fetch_assoc();

    if($array) 
    {
        //Load save game.
        $score = $array["score"]; 
        $lives = $array["lives"]; 
        $paddle = $array["paddle"]; 
        $ballx = $array["ballx"]; 
        $bally = $array["bally"];
        $ballxdist = $array["ballxdist"]; 
        $ballydist = $array['ballydist']; 
        $blocks = json_decode($array["blocks"]); 
    
        $data = ['score' => $score, 'lives' => $lives, 'paddle' => $paddle, 'ballx' => $ballx, 'bally' => $bally, 'ballxdist' => $ballxdist, 'ballydist' => $ballydist, 'blocks' => $blocks];  
        
        echo json_encode($data);
    }
    else 
    {
        //No save game in database. 
        mysqli_close($db);
        echo "No saved game found in the database.";
    }

    mysqli_close($db);
}
else
{
    //User is not logged in.
    mysqli_close($db);
    echo "Please login to load from the database.";
}

?>