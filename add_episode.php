<?php // add_episode.php
	require_once 'mysql_login.php';
	$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
	
	// format input
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  		$episode = $_POST['episode'];
  		$serie_ID = $_POST['serie_ID'];
		$title = $_POST['title'];
		
		$query = "INSERT INTO episodes( episode, serie_ID, title )
				VALUES( '$episode', '$serie_ID', '$title' )"; 
		$connection->query( $query );
	}
	
require_once 'header.php';
?>

<head><title>Add Entry</title></head>

<form action='add_episode.php' method='post'>
	<p>Episode:<input type='text' name='episode'/></p>
	<p>Serie ID:<input type='text' name='serie ID'/></p>
	<p>Title:<input type='text' name='title'/></p>
	<p><input type='submit' value='submit'/>
</form>


