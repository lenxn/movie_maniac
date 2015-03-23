<?php // search.php
// header( 'Content-type: text/plain; charset=utf-8' );
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';
echo "<head><title>Search</title></head>";
if( !isset( $_SESSION['loggedin'] )) {
	header( 'Location: http://movie-maniac.ddns.net/login.php' );
	exit;
}

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
	if( $connection->error ) die( $connection->error );
	$connection->set_charset( 'utf-8' );

	$title = $_POST['title'];
	$release_date = $_POST['release_date'];
	$director = $_POST['director'];
	$language = $_POST['language'];
	$subtitle = ''; //$_POST['subtitle'];
	$resolution = $_POST['resolution'];

	$query = "SELECT * from films WHERE title LIKE '%$title%' AND release_date LIKE '%$release_date%' AND director LIKE '%$director%' AND language LIKE '%$language%' AND subtitle LIKE '%$subtitle%' AND resolution LIKE '%$resolution%'";
	$result = $connection->query( $query );
}
?>

<h1>Select from Database</h1>
<div class="search-container">
	<form method='post' action='movie_search.php'>
		<p>Title:<input type='text' name='title'/></p>
		<p>Release Date:<input type='text' name='release_date'/></p>
		<!-- <p>Genre: [comming soon]</p> -->
		<p>Director:<input type='text' name='director'/></p>
		<p>Language:<select name='language'>
					<option value=''>All</option>
					<option value='English'>English</option>
					<option value='German'>German</option>
					<option value='French'>French</option>
					<option value='Russian'>Russian</option></select></p>
		<p>Subtitles:<input type='radio' name='subtitle' value=0 checked='checked'>All
					<input type='radio' name='subtitle' value=1>Subbed</p>
		<p>Resolution:<select name='resolution'>
					<option value=''>All</option>
					<option value='720'>720p</option>
					<option value='1080'>1080p</option></p>
		<p><input type='submit' value='Search'></p>
	</form>
</div>

<?php
if( isset($result) ) {
	echo "<p class=\"system-prompt\">" . $result->num_rows . " result(s) matching the criteria.</p>";
	draw_table( $result, 35 ); 
}
?>
</div>
</div>
</body>
</html>
