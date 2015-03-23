<?php // alter_database_films.php
require_once 'header.php';
require_once 'mysql_login.php';

$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$new_title = $_POST['title'];
	$new_release_date = $_POST['release_date'];
	$new_duration = $_POST['duration'];
	$new_director = $_POST['director'];
	$new_language = $_POST['language'];

	$new_query = "UPDATE films SET title='" . $new_title . "', release_date=" . $new_release_date . ", director='" . $new_director . "', language='" . $new_language . "' WHERE ID=" . $_GET['selection'];


	$new_result = $connection->query( $new_query );
	if( !$new_result )
		echo "Could not add to database!";
}

$query = "SELECT * FROM films WHERE ID=" . $_GET['selection'];
$result = $connection->query( $query );

$row = $result->fetch_array( MYSQLI_ASSOC );

// initialize variables
$title =	$row['title'];
$release_date =	$row['release_date'];
$duration = 	$row['duration'] . 'min';
$genre = 	fetch_genres( $connection, $_GET['selection'] );
$IMDB_rating = 	'';
$language = 	$row['language'];
$subtitle =	$row['subtitle'];
$country = 	fetch_countries( $connection, $_GET['selection'] );
$director = 	$row['director'];
$starring =	'actors [comming soon] ... ';
$discription =  '[comming soon] ...';

$format = 	$row['format'];
$quality =	$row['resolution'];
$size =		adjust_size( $row['size'] );

$cover = 	"src/movies/" . $row['folder'] . "/" . $row['src_cover'];
$ref = 		"src/movies/" . $row['folder'] . "/" . $row['src_file'];
$ref_subtitle = check_sub( $subtitle, $row['folder'], $row['src_subtitle'] );

?>

<form method='post' action='alter_database_films.php?selection=<?php echo $_GET['selection']; ?>'>
	<p>Title:</p>
	<p><input type='text' name='title' value='<?php echo $title; ?>'/></p>
	<p>Release Date:</p>
	<p><input type='text' name='release_date' value='<?php echo $release_date; ?>'/></p>
	<p>Duration:</p>
	<p><input type='text' name='duration' value='<?php echo $duration ?>'/></p>
	<p>Genre:</p>
	<p><input type='text' name='genre' value='<?php echo $genre ?>'/></p>
	<p>IMDB Rating:</p>
	<p><input type='text' name='IMDB_rating' value='<?php echo $IMDB_rating ?>'/></p>
	<p>Language:</p>
	<p><input type='text' name='language' value='<?php echo $language; ?>'/></p>
	<p>Subtitle:</p>
	<p><input type='radio' name='subtitle' value=0 <?php if( $subtitle == 0 ) { echo "checked"; } ?>/>Nosubs
		<input type='radio' name='subtitle' value=1 <?php if( $subtitle == 1 ) { echo "checked"; } ?>/>Subbed</p>
	<p>Coutry:</p>
	<p>Director:</p>
	<p><input type='text' name='director' value='<?php echo $director ?>'/></p>
	<p>Starring:</P>
	<p>Description:</p>
	<p><input type='submit' value='Update'/>

</form>

</div>
</div>
</body>
</html>
