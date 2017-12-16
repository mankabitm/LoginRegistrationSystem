<?php

	include("connect.php");
	include("functions.php");

	if(logged_in())
	{
		echo "Logged in";
	?>
		<a href="logout.php" style="float:right; padding:10px; margin-right:40px; background-color:#eee; color:#333; text-decoration:none;">Logout</a>
	<?php
	}
	else
	{
		header("location:login.php");
		exit();
	}
?>