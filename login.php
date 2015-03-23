<?php // login.php
	require_once 'mysql_login.php';
	require_once 'functions.php';
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      session_start();
      // initilization
      $error_level = "";

		$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
		if( $connection->connect_error ) die( $connection->connect_error );

	     	$username = $_POST['username'];
	     	$token = $_POST['password'];
		$password = hash( 'md5', $salt1 . $token . $salt2 );

	      $hostname = $_SERVER['HTTP_HOST'];
	      $path = dirname($_SERVER['PHP_SELF']);
		$query = "SELECT * FROM members WHERE username='$username' AND password='$password'";

		$result = $connection->query( $query );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		if( $result->num_rows == 0 )
			$error_level = "invalid username, password combination</body></html>";
		else
		{
			$_SESSION['loggedin']  = true;
			$_SESSION['name'] = $row['first_name'];
			$_SESSION['username'] = $row['username'];
			if( $row['admin'] == 1 )
				$_SESSION['isadmin'] = 'TRUE';
			header('Location: http://'.$hostname.($path == '/' ? '' : $path) . '/index.php');
			$error_level = "login successfull";

			exit;
		}
      }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <meta charset='utf-8'/>
  <title>Login</title>
  <style>
	@import url('styles/login.css'); 

  </style>
 </head>
 <body>
 	<div id='container'>
			<p>Authentication</p>
				<form action="login.php" method="post">
					<span>Username:</span>
					<input type='text' name='username' autofocus='autofocus'/>
					<span>Password:</span>
					<input type='password' name='password'/>
					<input type='submit' value='LOGIN'/>
				</form>
		<div id='error'>
			<p class='error_message'><?php echo $error_level; ?></p>
		</div>
	</div>
</body>
</html>
