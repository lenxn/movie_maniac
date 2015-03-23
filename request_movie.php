<?php // request_movie.php
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{
	$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
	if( $connection->error ) die( $connection->error );
	$connection->set_charset( 'utf-8' );
	
	$query = "SELECT * from test";
	$result = $connection->query( $query );
	if( !$result ) die( "Query failed" );
	$row = $result->fetch_array( MYSQL_ASSOC );
	echo $row['title'];
	echo $_POST['suggestion'];
}
?>
<p>The request system offers the users the possibility to submit movie suggestions to be reviewed by the staff.
Once a title is submitted, it will remain pending until it is reviewed by one of the staff members, who will add it to his 'to-do list', if the title is in accordance with the <a href=''>website rules</a>.
</p>
<p>Please submit your suggestion either by movie name <span class='example'>e.g. Avatar (2008)</span>, IMDb Link or IMDb Code <span class='example'>(e.g. tt0499549)</span>.
</p>

<form method='post' action='request_movie.php'>
	Movie Suggestion:<input type='text' name='suggestion' autofocus='autofocus'/>
	<input type='submit' value='Submit'/>
</form>
</form>
</div>
</div>
</body>
</html>