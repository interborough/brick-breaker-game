<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php

//Login users
session_start();
//PERSONAL DATABASE INFO REMOVED
$db = mysqli_connect('hostname', 'username', 'password', 'schema') or die("Could not connect to database");
$username = $_POST['username'];
$password = $_POST['password'];

if(isset($_POST['login']))
 {
    $errors = array();

    if(empty($username))
    {
        array_push($errors, "Username is required");
    }
    if(empty($password))
    {
        array_push($errors, "Password is required");
    }
    if(count($errors) == 0)
    {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $results = mysqli_query($db, $query);

        if(mysqli_num_rows($results)) 
        {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Logged in Successfully";

            echo "<p style='color:white;'>" . "You are now logged in. Redirecting in 3 seconds..." . "</p>";
        }
        else
        {
            array_push($errors, "Wrong username and password combination. Please try again. Redirecting in 3 seconds...");
        }
    }

    mysqli_close($db);
    header("refresh:3; url=index.html"); 
 }
 else
 {
   session_start();
   $errors = array();

   //Register users
   $confirmpassword = $_POST['confirmpassword'];

   //form validation

   if(empty($username))
   {
      array_push($errors, "Username is required");
   } 

   if(empty($password))
   {
      array_push($errors, "Password is required");
   } 

   if($password != $confirmpassword)
   {
      array_push($errors, "Password do not match");
   }

   //check database for existing user with same username
   $user_check_query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";

   $results = mysqli_query($db, $user_check_query);
   $user = mysqli_fetch_assoc($results);

   if($user)
   {
      if($user["username"] === $username)
      {
          array_push($errors, "This username is already registered");
      }
   }

   //Register user if no errors

   if(count($errors) == 0)
   {
      $password = md5($password);

      $query = "INSERT INTO users VALUES ('$username', '$password')";
      mysqli_query($db, $query);

      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now registered.";

      echo "<p style='color:white;'>" . "You are now registered. Redirecting in 3 seconds..." . "</p>";
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
    <!--redirect to login.php after 3 seconds-->
    <?php header("Refresh:3; url=login.php"); ?>
    </div>
    
    <?php endif ?>
</body>
</html>