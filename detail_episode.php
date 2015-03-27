<?php // detail_episode.php
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';

$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
if( $connection->error ) die( $connection->error );

$query = "SELECT * FROM episodes LEFT JOIN series ON series.ID=episodes.serie_ID WHERE episodes.ID=" . $_GET['selection'];
$result = $connection->query( $query );
$row = $result->fetch_array( MYSQLI_ASSOC );

// initialize variables
$title = $row['title'];
$release_date =	$row['release_date'];

if( $row['season'] != 0 )
	$ref = "src/series/" . $row['folder'] . "/S" . $row['season'] . "E" . $row['episode'] . "." . $row['format'];
else
	$ref = "src/series/" . $row['folder'] . "/" . $row['src_file'] . "." . $row['format'];


echo "<head><title>" . $title . "</title></head>";
if( $row['subtitle'] == 0 )
	$subtitle = '';
else
	$subtitle = ' - with Subtitle';


?>
<div id='properties'>
		<!-- <img class='image' src='cover.jpg' alt='poster_large.jpg'> -->
		<div id='info'>
		<?php
			if( ( $row['season'] && $row['episode'] ) != 0 ) {
				echo "<h1>" . $title . " - Season " . $row['season'] . " (" . $row['release_date'] . ")</h1>";
				echo "<h2>Episode " . $row['episode'] . " - " . $row['episode_title'] . "</h2>";
			}
			else {
				echo "<h1>" . $title . "</h1>";
				echo "<h2>" . $row['episode_title'] . " - " . $row['release_date'];
			}
		?>
		</div>
</div>

<?php /* if( $row['format'] == 'mp4' )
echo <<<_END
<div id='stream'>
	<h2>Watch Stream</h2>
	<video width="560" height="315" controls>
		<source src="src/series/Game_of_Thrones/S04E01.mp4" type="video/mp4">
		Your browser does not support mp4.
	</video>
</div>
_END; */
?>

<div id='download-links'>
	<h2>Download</h2>
	<p><?php echo "<a href='" . $ref . "'download>[moviefile]</a>"; ?></p>
</div>
