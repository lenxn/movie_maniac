<?php // serie_search.php
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';

echo "<head><title>Search Serie</title></head>";
if( !isset( $_SESSION['loggedin'] )) {
	header( 'Location: http://movie-maniac.ddns.net/login.php' );
	exit;
}

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
	if( $connection->error ) die( $connection->error );

	$title = $_POST['title'];
	$language = $_POST['language'];
	$subtitle = ''; //$_POST['subtitle'];

	$query = "SELECT * from series WHERE title LIKE '%$title%' AND language LIKE '%$language%'";
	$result = $connection->query( $query );
}
?>
<p>Feature comming soon.</p>
<form action='serie_search.php' method='post'>
	<p>Title<input type='text' name='title'/></p>
	<p>Language<input type='text' name='language'/></p>
	<p><input type='submit' value='Search'></p>
</form>
<?php
if( $_SERVER['REQUEST_METHOD'] == 'POST' && $result )
{
	draw_table_series( $result, $result->num_rows );
}
?>

</div>
</div>
</body>
</html>