<!-- <?php 
// include("database.php");

//   $username = "Venolope";
//   $password = "sekretlngs";
//   $hash = password_hash($password, PASSWORD_DEFAULT);

// $sql = "INSERT INTO users (`user`, `password`)
//         VALUES('$username', '$hash')";

// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . mysqli_error($conn);
// }

// mysqli_close($conn);
?> -->

<!-- <?php
  // include("database.php");

  // $sql = "SELECT * FROM users";
  // $result = mysqli_query($conn, $sql);

  // if(mysqli_num_rows($result) > 0){
  //   while($row = mysqli_fetch_assoc($result)){
  //   echo $row["id"] . "<br>";
  //   echo $row["user"] . "<br>";
  //   echo $row["reg_date"] . "<br>";  
  //   };
  // }
  // else{
  //   echo "No user found";
  // }

  // mysqli_close($conn);
?> -->
<?php
  include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h2>Welcome to Fakebook!</h2>
  <form action="<? htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post"> 
      Username: <br>
      <input type="text" name="username">
      Password: <br>
      <input type="password" name="password">
      <input type="submit" name="register" value="Register">
  </form>
</body>
</html>


<?php 

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if(empty($username)){
      echo "please enter a username";
    }
    elseif(empty($password)){
      echo "please enter a password";
    }
    else{
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users(user, password)
              VALUES ('$username', '$hash')";
     try{
       mysqli_query($conn, $sql);
       echo "You are now registered!";
     }
     catch(mysqli_sql_exception){
      echo "That username is already taken.";
     }
    }
  
    }
    
    mysqli_close($conn);

    


?>

