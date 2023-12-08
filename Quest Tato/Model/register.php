<?php
session_start();

	if(isset($_POST["submit"]))
	{
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$score = $_POST["score"];
		
		$conn = mysqli_connect("localhost","root","","questtato");
					
				if(!$conn)
				{
					die("Cannot connect our Database");
				}
		
		// Prepare a SQL query to check if the email and username already exist in the database
$sql = "SELECT email, username FROM players WHERE email = '" . $_POST['email'] . "' OR username = '" . $_POST['username'] . "'";



// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Check if the email and username already exist
$emailExists = false;
$usernameExists = false;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['email'] === $_POST['email']) {
        $emailExists = true;
    }
    if ($row['username'] === $_POST['username']) {
        $usernameExists = true;
    }
}

// If email or username already exists, display an error message and stop execution
if ($emailExists) {
    echo "<script>alert('Error: This email address is already exists! Please use a different email address.')</script>";
	echo "<script>window.history.back()</script>";
    exit();
}
if ($usernameExists) {
    echo "<script>alert('Error: This username is already exists! Please use a different username.')</script>";
	echo "<script>window.history.back()</script>";
    exit();
}

// sql query for insert the register creditionals
$sql = "INSERT INTO players (email, username, password, score) VALUES ('" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $_POST['password'] . "', null)";


if (mysqli_query($conn, $sql)) {
    // Redirect the user to the login page
    header("Location: login.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="../View/Styles/register.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<script src="../Controller/loginvalidation.js" ></script>
</head>
<body>
	<div class="container">
		<div class="image-container">
			<img src="../View/Images/loginTomato.png" alt="Background Image">
		</div>
		<div class="form-container">
			<div class="header">
				<h1>Sign up</h2>
			</div>
			<div class="login-box">
				
				<!-- form to Enter the email,username and password  -->
				<form action="" method="post" onsubmit="return validateForm(event)">
                    <label for="email" class="fa fa-envelope"><b> Email</b></label>
					<input type="text" id="email" name="email" placeholder="Enter the email" required>

					<label for="username" class="fas fa-user-alt"><b> Username</b></label>
					<input type="text" id="username" name="username" placeholder="Enter the username" required>

					<label for="password" class="fa fa-key"><b> Password</b></label>
					<input type="password" id="password" name="password" placeholder="Enter the password" required>
					</br>
          <div class="button-container">
		  			<!--  Reset and Register button -->
            <button class="button left-button" type="reset">Reset</button>
            <button class="button center-button" type="submit" name="submit" id="submit" value="submit" >Sign up</button>
			
          </div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

