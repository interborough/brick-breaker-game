<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Registration</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php
session_start();

//Note: Database information removed for Github.
$server_hostname = "";
$server_username = "";
$server_password = "";
$server_dbname = "";

$db = mysqli_connect($server_hostname, $server_username, $server_password, $server_dbname) or die ("Could not connect to database.");

$username = $_POST['username'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];
$errors = array();

if(isset($_POST['login']))
 {
    if(empty($username))
    {
        array_push($errors, "A username is required for account creation.");
    }
    if(empty($password))
    {
        array_push($errors, "A password is required for account creation.");
    }

    if(count($errors) == 0)
    {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $results = mysqli_query($db, $query);

        if(mysqli_num_rows($results)) 
        {
            $_SESSION['username'] = $username;
            echo "<p style='color:white;'>" . "You are now logged in. Redirecting in 3 seconds." . "</p>";
        }
        else
        {
            array_push($errors, "Account not found. Please try again.");
        }
    }

    mysqli_close($db);
    header("refresh:3; url=index.html"); 
 }
 else
 {
   $errors = array();

   if(empty($username))
   {
      array_push($errors, "A username is required to login.");
   } 

   if(empty($password))
   {
      array_push($errors, "A password is required to login.");
   } 

   if($password != $confirmpassword)
   {
      array_push($errors, "The passwords do not match.");
   }

   //check database for existing user with same username
   $user_check_query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";

   $results = mysqli_query($db, $user_check_query);
   $user = mysqli_fetch_assoc($results);

   if($user)
   {
      if($user["username"] === $username)
      {
          array_push($errors, "This username is already registered.");
      }
   }

   //Register user if no errors

   if(count($errors) == 0)
   {
      $password = md5($password);

      $query = "INSERT INTO users VALUES ('$username', '$password')";
      mysqli_query($db, $query);

      $_SESSION['username'] = $username;

      echo "<p style='color:white;'>" . "You are now registered. Redirecting in 3 seconds." . "</p>";
      mysqli_close($db);
      header("refresh:3; url=index.html"); 
   }
 
}

?>
<?php if (is_countable($errors) && count($errors) > 0) : ?>
    <div>
    <?php foreach($errors as $error) : ?>
    <p><?php echo $error ?></p>
    <?php endforeach ?>
    <p><?php echo "<p style='color:white;'>" . "Redirecting in 3 seconds." . "</p>"; ?></p>
    <?php header("Refresh:3; url=login.html"); ?>
    </div>
    <?php endif ?>
</body>
</html>