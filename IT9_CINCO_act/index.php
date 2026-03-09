<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Personal Profile Generator</title>


<style>
body{
    background:#f4f4f4;
}

.form-container{
    max-width:600px;
    margin:auto;
    margin-top:40px;
    padding:30px;
    background:white;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,3.1);
}
</style>

</head>

<body style="background-color: #FFFDD0;">

<div class="container">

<div class="form-container">

<h2 class="text-center mb-4">Personal Profile Generator</h2>

<form action="profile.php" method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="fullname" class="form-control" required>
</div>

<br>

<div class="mb-3">
<label class="form-label">Age</label>
<input type="number" name="age" class="form-control" min="1" max="120" required>
</div>

<br>

<div class="mb-3">
<label class="form-label">Course / Program</label>
<input type="text" name="course" class="form-control" required>
</div>

<br>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<br>

<div class="mb-3">
<label class="form-label">Gender</label><br>

<input type="radio" name="gender" value="Male" required> Male <br>
<input type="radio" name="gender" value="Female"> Female <br>
<input type="radio" name="gender" value="Other"> Other <br>

</div>

<br>

<div class="mb-3">

<label class="form-label">Hobbies</label><br>

<input type="checkbox" name="hobbies[]" value="Reading"> Reading <br>
<input type="checkbox" name="hobbies[]" value="Gaming"> Gaming <br>
<input type="checkbox" name="hobbies[]" value="Traveling"> Traveling <br> 
<input type="checkbox" name="hobbies[]" value="Sports"> Sports <br>
<input type="checkbox" name="hobbies[]" value="Music"> Music <br>

</div>

<br>

<div class="mb-3">

<label class="form-label">Short Biography</label>
<br>
<textarea name="bio" class="form-control" rows="12"></textarea>

</div>

<br>

<div class="mb-3">

<label class="form-label">Upload Profile Image</label>

<input type="file" name="profile_image" class="form-control" required>

</div>

<button type="submit" class="btn btn-active w-100">
Generate Profile
</button>

</form>

</div>

</div>

</body>
</html>