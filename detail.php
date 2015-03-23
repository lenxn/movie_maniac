<?php // detail.php
require_once 'header.php';
require_once 'mysql_login.php';

$query = "SELECT * FROM films WHERE ID=" . $_GET['selection'];
$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
$result = $connection->query( $query );

$row = $result->fetch_array( MYSQLI_ASSOC );

// initialize variables
$title =	$row['title'];
$release_date =	$row['release_date'];
$duration = 	$row['duration'] . 'min';
$genre = 	fetch_genres( $connection, $_GET['selection'] );
$IMDB_rating = 	'rating [comming soon]';
$language = 	$row['language'];
$sub_exist =	$row['subtitle'];
$country = 	fetch_countries( $connection, $_GET['selection'] );
$director = 	$row['director'];
$starring =	'actors [comming soon] ... ';
$discription =  '[comming soon] ...';

$format = 	$row['format'];
$quality =	$row['resolution'];
$size =		adjust_size( $row['size'] );

$cover = 	"src/movies/" . $row['folder'] . "/" . $row['src_cover'];
$ref = 		"src/movies/" . $row['folder'] . "/" . $row['src_file'];
$ref_subtitle = check_sub( $sub_exist, $row['folder'], $row['src_subtitle'] );

echo "<head><title>" . $title . "</title></head>";
if( $row['subtitle'] == 0 )
	$subtitle = '';
else
	$subtitle = ' - with Subtitle';


?>
<div id='properties'>
		<img class='image' src='cover.jpg' alt='poster_large.jpg'>
		<div id='info'>
			<h1><?php echo $title . " - (" . $release_date; ?> )</h1>
				<h2><?php if( $duration != 0 )
					echo $duration ?></h2>
		        <h2><?php //echo $duration . " - " . $genre . " - " . $IMDB_rating; ?></h2>
				<p><?php if( $director )
					echo "<span class='property'>Director:</span>" . $director; ?></p>		        
				<p><?php if( $language )
					echo "<span class='property'>Language:</span>" . $language . $subtitle; ?></p>
				<p><?php if( $country )
					echo "<span class='property'>Country:</span>" . $country; ?></p>
				<p><?php //echo "<span class='property'>Starring:</span>" . $starring; ?></p>
				<p><?php //echo "<span class='property'>Discription:</span>" . $discription; ?></p>

				<br/>
				<p><?php if( $format )
					echo "<span class='property'>Format:</span>" . $format; ?></p>
				<p><?php if( $quality )
					echo "<span class='property'>Quality:</span>" . $quality . "p"; ?></p>
				<p><?php if( $size )
					echo "<span class='property'>Size:</span>" . $size; ?></p>					

	<?php if( isset( $_SESSION['isadmin'] )) {
		echo "<tr><td><a href='edit_entry.php?selection=" . $row['ID'] . "'>[Edit Entry]</a></td></tr>";
	} ?>
		</div>
</div>

<?php /*
echo <<<_END
<div id='trailer'>
	<h2>Watch Trailer</h2>
	<iframe width="560" height="315" src="//www.youtube.com/embed/iVAgTiBrrDA" frameborder="0" allowfullscreen></iframe>
</div>
_END;

if( $row['format'] == 'mp4' )
echo <<<_END
<div id='stream'>
	<h2>Watch Stream</h2>
	<video width="560" height="315" controls>
		<source src="Game.mp4" type="video/mp4">
		<source src="Partygraz.ogg" type="video/ogg">
		Your browser does not support mp4.
	</video>
</div>
_END; */
?>

<div id='download-links'>
	<h2>Download Links</h2>
	<p class="download-link"><?php echo "<a href='" . $ref . "'download>[download]</a>" . $ref_subtitle; ?></p>
</div>
			
</div>
</div>

</body>
</html>
