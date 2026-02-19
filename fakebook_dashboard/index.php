<?php
  include('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
    <h1>Welcome to user Login Info!</h1>
    <hr>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label>username: </label>
    <input type="text" name="username"><br><br>
    <label>password: </label>
    <input type="password" name="password"><br><br>
    <label>Input your favorite food: </label>
    <input type="text" name="favoritefood">
    <input type="submit" name="login" value="login">
  </form>

</body>
</html>

<?php

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $fav_food = htmlspecialchars($_POST['favoritefood']);

    if(empty($username)){
      echo "Username is missing.";
    }
    elseif(empty($password)){
      echo "Password is missing.";
    }
    elseif(empty($fav_food)){
      echo "Favorite food is missing.";
    }
    else{
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql =  "INSERT INTO users(username, password, fav_food)
                VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $fav_food);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      
      if(mysqli_stmt_execute($stmt)){
        echo "You are now logged in. ";
      } else {
        if(mysqli_errno($conn) == 1062){
          echo "That username is already taken.";
        } else {
          echo "Something went wrong.";
        }
      }
    }
  }

  
?>

