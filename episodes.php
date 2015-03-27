<?php // episodes.php
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';

$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
if( $connection->error ) die( $connection->error );

$query = "SELECT * FROM series LEFT JOIN episodes on series.ID=episodes.serie_ID WHERE series.ID=" . $_GET['selection'];
$result = $connection->query( $query );
$row = $result->fetch_array( MYSQLI_ASSOC );

$title = $row['title'];
$release_date =	$row['release_date'];
$cover = "src/series/" . $row['folder'] . "/" . $row['folder'] . "_" . $row['episode'] . ".jpg";

echo "<head><title>" . $title . "</title></head>";
if( $row['subtitle'] == 0 )
	$subtitle = '';
else
	$subtitle = ' - with Subtitle';


if( ( $row['season'] && $row['episode'] ) != 0 ) {		
	$header = "<h1>" . $title . " - Season " . $row['season'] . " (" . $row['release_date'] . ")</h1>";
	$cover = "src/series/" . $row['folder'] . "/" . $row['folder'] . "_" . $row['episode'] . ".jpg";
}
else {
	$header = "<h1>" . $title . "</h1>";
	$cover = "src/series/" . $row['folder'] . "/" . $row['folder'] . ".jpg";
}
?>

<!-- HTML outpu -->
<div id='properties'>
		<img class='image' src='<?php echo $cover; ?>' alt='No cover for this movie.'>
		<div id='info'>
			<?php echo $header ?>
		</div>
</div>

<?php
	draw_table_episodes( $result, $result->num_rows );
?>