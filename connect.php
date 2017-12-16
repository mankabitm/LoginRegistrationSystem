<?php
	$con=mysqli_connect("localhost","root","","registration");
	if(mysqli_connect_errno())
	{
		echo "Error while connecting".mysqli_connect_errno();
	}
	session_start();

?>