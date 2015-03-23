<?php // top_rated_movies.php
// header( 'Content-type: text/plain; charset=utf-8' );
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';
echo "<head><title>Search</title></head>";
if( !isset( $_SESSION['loggedin'] )) {
	header( 'Location: http://movie-maniac.ddns.net/login.php' );
	exit;
}


	$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
	if( $connection->error ) die( $connection->error );
	$connection->set_charset( 'utf-8' );

	$query = "SELECT * from films ORDER BY IMDb_rating DESC";
	$result = $connection->query( $query );
	if( !$result ) die( "Query failed" );


draw_table( $result, 25 ); 
?>
</div>
</div>
</body>
</html>