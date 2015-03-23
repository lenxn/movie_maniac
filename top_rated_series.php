<?php // serie_search.php
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';

echo "<head><title>Search Serie</title></head>";
if( !isset( $_SESSION['loggedin'] )) {
	header( 'Location: http://movie-maniac.ddns.net/login.php' );
	exit;
}

$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
if( $connection->error ) die( $connection->error );

$query = "SELECT * FROM series ORDER BY title";
$result = $connection->query( $query );
	
?>
<h1>Series:</h1>

<?php
draw_table_series( $result, $result->num_rows );

?>

</div>
</div>
</body>
</html>