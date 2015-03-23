<?php // detail_serie.php
require_once 'header.php';
require_once 'mysql_login.php';

$query = "SELECT * FROM series WHERE ID=" . $_GET['selection'];
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
		        <h2><?php echo $duration . " - " . $genre . " - " . $IMDB_rating; ?></h2>
				<p><?php echo "<span class='property'>Language:</span>" . $language . $subtitle; ?></p>
				<p><?php echo "<span class='property'>Country:</span>" . $country; ?></p>
				<p><?php echo "<span class='property'>Director:</span>" . $director; ?></p>
				<p><?php echo "<span class='property'>Starring:</span>" . $starring; ?></p>
				<p><?php echo "<span class='property'>Discription:</span>" . $discription; ?></p>
	<?php if( isset( $_SESSION['isadmin'] )) {
		echo "<tr><td><a href='edit_entry.php?selection=" . $row['ID'] . "'>[Edit Entry]</a></td></tr>";
	} ?>
		</div>
</div>
<div id='trailer'>
	<h2>Watch Trailer</h2>
	<iframe width="560" height="315" src="//www.youtube.com/embed/iVAgTiBrrDA" frameborder="0" allowfullscreen></iframe>
</div>

<div id='stream'>
	<h2>Watch Stream</h2>
	<video width="560" height="315" controls>
		<source src="Game.mp4" type="video/mp4">
		<source src="Partygraz.ogg" type="video/ogg">
		Your browser does not support mp4.
	</video>
</div>

<div id='download-links'>
	<h2>Download</h2>
	<p><?php echo $format . $quality . " - " . $size . "</td><td class='txt_td'><a href='" . $ref . "'download>[moviefile]</a>" . $ref_subtitle; ?></p>
</div>
			
</div>
</div>

</body>
</html>
