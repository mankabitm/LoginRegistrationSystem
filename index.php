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
		$firstName = $_POST['fname'];
		$lastName = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];

		$image = $_FILES['image']['name'];
		$tmp_image = $_FILES['image']['tmp_name'];
		$imageSize = $_FILES['image']['size'];

		$date = date("F, d Y");

		if(strlen($firstName) < 3)
		{
			$error="First name is too short";
		}
		else if(strlen($lastName) < 3)
		{
			$error="Last name is too short";
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			$error="Please enter valid email address";
		}
		else if(strlen($password) < 8)
		{
			$error="Password must be greater than 8 characters";
		}
		else if($password !== $passwordConfirm)
		{
			$error="Passwords do not match";
		}
		else if($image == "")
		{
			$error="Please upload your image";
		}
		else if($imageSize > 1048576)
		{
			$error="Image size must be less than 1 MB";
		}
		else
		{
			$password = md5($password);

			$imageExt = explode(".",$image);
			$imageExtension = $imageExt[1];

			if($imageExtension=='PNG' || $imageExtension=='png' || $imageExtension=='jpg' || $imageExtension=='JPG')
			{
				$image = rand(0,100000).rand(0,100000).rand(0,100000).time().".".$imageExtension;

				$insertQuery = "INSERT INTO users(firstName,lastName,email,password,image,date) VALUES('$firstName','$lastName','$email','$password','$image','$date')";
				if(mysqli_query($con,$insertQuery))
				{
					if(move_uploaded_file($tmp_image,"images/$image"))
					{
						$error = "Registered successfully";
					}
					else
					{
						$error = "Image not uploaded";
					}
				}
			}
			else
			{
				$error = "File is not an image";
			}

		}
	}
?>

<!DOCTYPE html>
<html>
		<head>
			<title>REGISTRATION PAGE</title>
			<link rel="stylesheet" href="css/styles.css" />
		</head>
		<body>
			<div id="error">
				<?php echo $error; ?>
			</div>
			<div id="wrapper">
				<div id="menu">
					<a href="index.php">Sign Up</a>
					<a href="login.php">Login</a>
				</div>
				<div id="formDiv">
					<form method="POST" action="index.php" enctype="multipart/form-data">
						<label>First Name:</label><br/>
						<input type="text" name="fname" /><br/><br/>
						<label>Last Name:</label><br/>
						<input type="text" name="lname" /><br/><br/>
						<label>Email:</label><br/>
						<input type="text" name="email" /><br/><br/>
						<label>Password:</label><br/>
						<input type="password" name="password" /><br/><br/>
						<label>Re-enter Password:</label><br/>
						<input type="password" name="passwordConfirm" /><br/><br/>
						<label>Image:</label><br/>
						<input type="file" name="image" /><br/><br/>
						<input type="submit" name="submit" />
					</form>
				</div>
			</div>
		</body>
</html>