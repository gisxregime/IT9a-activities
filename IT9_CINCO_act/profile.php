<?php

function clean_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$fullname = clean_input($_POST['fullname']);
$age = clean_input($_POST['age']);
$course = clean_input($_POST['course']);
$email = clean_input($_POST['email']);
$gender = clean_input($_POST['gender']);
$bio = clean_input($_POST['bio']);

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    die("Invalid email format");
}

$hobbies = [];

if(isset($_POST['hobbies'])){
    foreach($_POST['hobbies'] as $hobby){
        $hobbies[] = clean_input($hobby);
    }
}

$hobbyList = implode(", ", $hobbies);

$target_dir = "uploads/";

$imageName = basename($_FILES["profile_image"]["name"]);
$tempName = $_FILES["profile_image"]["tmp_name"];

$fileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

$allowedTypes = ["jpg","jpeg","png","gif"];

if(!in_array($fileType, $allowedTypes)){
    die("Only JPG, JPEG, PNG, GIF allowed.");
}

$newFileName = uniqid() . "." . $fileType;

$target_file = $target_dir . $newFileName;

move_uploaded_file($tempName, $target_file);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Generated Profile</title>


<style>

body{
    background:#f2f2f2;
}

.profile-card{
    max-width:600px;
    margin:auto;
    margin-top:50px;
}

</style>

</head>

<body>

<div class="container">

<div class="card profile-card shadow">

<div class="card-body text-center">

<img src="<?php echo $target_file; ?>"
style="width:150px;height:150px;object-fit:cover;border-radius:50%;">

<h3 class="mt-3"><?php echo $fullname; ?></h3>

<p class="text-muted"><?php echo $course; ?></p>

<hr>

<p><b>Age:</b> <?php echo $age; ?></p>

<p><b>Email:</b> <?php echo $email; ?></p>

<p><b>Gender:</b> <?php echo $gender; ?></p>

<p><b>Hobbies:</b> <?php echo $hobbyList; ?></p>

<p><b>Biography:</b></p>

<p><?php echo $bio; ?></p>

<a href="index.php" class="btn btn-primary mt-3">
Create Another Profile
</a>

</div>

</div>

</div>

</body>

</html>