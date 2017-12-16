<?php

	include("connect.php");
	include("functions.php");

	if(logged_in())
	{
		header("location:profile.php");
		exit();
	}

	$error="";

	if(isset($_POST['submit']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$checkbox = isset($_POST['keep']);
		
		if(email_exists($email,$con))
		{
			$result=mysqli_query($con, "SELECT password FROM users WHERE email='$email'");
			$retrievepassword=mysqli_fetch_assoc($result);
			if(md5($password)!==$retrievepassword['password'])
			{
				$error="Invalid Password";
			}
			else
			{
				$_SESSION['email']=$email;
				if($checkbox == "on")
				{
					setcookie("email",$email,time()+3600);
				}
				header("location: profile.php");
			}
		}
		else
		{
			$error = "Email does not exist";
		}
	}
?>

<!DOCTYPE html>
<html>
		<head>
			<title>LOGIN PAGE</title>
			<link rel="stylesheet" href="css/styles.css" />
		</head>
		<body>
			<div id="error" style=" <?php if($error != "") { ?> display:block; <?php } ?>">
				<?php echo $error; ?>
			</div>
			<div id="wrapper">
				<div id="menu">
					<a href="index.php">Sign Up</a>
					<a href="login.php">Login</a>
				</div>
				<div id="formDiv">
					<form method="POST" action="login.php">
						<label>Email:</label><br/>
						<input type="text" name="email" class="inputFields" required/><br/><br/>
						<label>Password:</label><br/>
						<input type="password" name="password" class="inputFields" required/><br/><br/>
						<input type="checkbox" name="keep" />
						<label>Keep me logged in</label><br/><br/>
						<input type="submit" name="submit" class="theButtons" value="login"/>
					</form>
				</div>
			</div>
		</body>
</html>