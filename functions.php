<?php // functions.php

function sanitizeString( $var )
{
	global $connection;
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return $connection->real_escape_string($var);
}

function fetch_mysql( $query )
{
	global $connection;
	$result = $connection->query( $query );
	if( !$result ) die( $connection->error );
	return $result;
}

function draw_table( $result, $count )
{
	if( $result->num_rows < $count ) {
		$count = $result->num_rows;
	}
	echo "<table><tr class='headerspan'><td>Title</td><td>Download</td><td>Subtitle</td></tr>";
	for( $i = 0; $i < $count; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		$res = check_res( $row['resolution'] );
		$title = $row['title'] . "<span id='title_info'> (" . $row['release_date'] . ")" . $res . "</span>";
		$ref = "src/movies/" . $row['folder'] . "/" . $row['src_file'];
		$size = adjust_size( $row['size'] );
		$link_sub = check_sub( $row['subtitle'], $row['folder'], $row['src_subtitle'] );
		$row =	"<tr><td = class='column_title'><a class='titles' href='detail.php?selection=" . $row['ID'] . "'>" . $title . "</a></td>" .
			"<td class='indexcolumn' align='center'><a href='" . $ref . "' download>[" . $size . "]</a></td>" . $link_sub . "</tr>";
		echo $row;
	}
}

function draw_table_series( $result, $count )
{
	if( $result->num_rows < $count ) {
		$count = $result->num_rows;
	}
	echo "<table>";
	for( $i = 0; $i < $count; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		if( $row['season'] != 0 )
			$title = $row['title'] . "<span id='title_info'> [Season " . $row['season'] . "] (" . $row['release_date'] . ")</span>";
		else
			$title = $row['title'];

		$row =	"<tr><td = class='column_title'><a class='titles' href='episodes.php?selection=" . $row['ID'] . "'>" . $title . "</a></td>";
		echo $row;
	}
	echo "</table>";
}

function draw_table_episodes( $result, $count )
{
	if( $result->num_rows < $count ) {
		$count = $result->num_rows;
	}
	echo "<table>";
	for( $i = 0; $i < $count; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );

		if( $row['season'] != 0 )
			$ref = "src/series/" . $row['folder'] . "/S" . $row['season'] . "E" . $row['episode'] . "." . $row['format'];
		else
			$ref = "src/series/" . $row['folder'] . "/" . $row['src_file'] . "." . $row['format'];

		$row =	"<tr><td = class='column_title'>Episode [" . $row['episode'] . "] - <a class='titles' href='" . $ref . "'>" . $row['episode_title'] . "</a></td>";
		echo $row;
	}
	echo "</table>";
}

function draw_results( $result, $count )
{
	if( $result->num_rows < $count ) {
		$count = $result->num_rows;
	}
	for( $i = 0; $i < $count; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		$res = check_res( $row['resolution'] );
		$title = $row['title'];
		$ref = "src/movies/" . $row['folder'] . "/" . $row['src_file'];
		$size = adjust_size( $row['size'] );
		$link_sub = check_sub( $row['subtitle'], $row['folder'], $row['src_subtitle'] );
		$cover = 	"src/movies/" . $row['folder'] . "/" . $row['src_cover'];
		$element = "<a class='titles' href='detail.php?selection=" . $row['ID'] . "'><div class='coverframe'><h1>" . $title . "</h1><img src='" . $cover ."'/></div></a>";
		echo $element;
	}
}

function draw_results_series( $result, $count )
{
	if( $result->num_rows < $count ) {
		$count = $result->num_rows;
	}
	for( $i = 0; $i < $count; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		$title = $row['title'];
		$season = $row['season'];
		// $ref = "src/movies/" . $row['folder'] . "/" . $row['src_file'];
		// $link_sub = check_sub( $row['subtitle'], $row['folder'], $row['src_subtitle'] );
		$element = "<a class='titles' href='detail.php?selection=" . $row['ID'] . "'><div class='coverframe'><h1>" . $title . "</h1><img src='cover.jpg'/></div></a>";
		echo $element;
	}
}

function adjust_size( $value )
{
	if( $value == 0 )
		return "Download";
	elseif( $value < 1000 )
		return $value . "MB";
	else
	{
		$value = $value / 1000;
		$value = number_format( $value, 2 );
		return $value . "GB";
	}
}

function check_sub( $subtitle, $folder, $src_subtitle )
{
	if( $subtitle == 0 )
		return '';
	else
	{
		$ref_sub = "src/movies/" . $folder . "/" . $src_subtitle;
		return "<td align='center'><a href='" . $ref_sub . "' download>[sub]</a></td>";
	}
}

function check_res( $resolution )
{
	if( $resolution == 0 )
		return '';
	else
		return "[" . $resolution . "p]";
}

function fetch_countries( $connection, $ID )
{
	$query = "SELECT country FROM relation_countries JOIN countries ON relation_countries.C_ID=countries.COUNTRY_ID WHERE M_ID=" . $ID;
	$result = fetch_mysql( $query );
	$string = "";

	for( $i = 0; $i < $result->num_rows; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		$string = $string . $row['country'] . ", ";
	}
	$string = substr( $string, 0, strlen( $string ) -2 ); 	// deletes the comma at the end of the string ( 2, because last caracter is newline )
	return $string;
}
function fetch_genres( $connection, $ID )
{
	$query = "SELECT name FROM relation_genre JOIN genre ON relation_genre.G_ID=genre.ID WHERE M_ID=" . $ID;
	$result = fetch_mysql( $query );
	$string = "";

	for( $i = 0; $i < $result->num_rows; $i++ )
	{
		$result->data_seek( $i );
		$row = $result->fetch_array( MYSQLI_ASSOC );
		$string = $string . $row['name'] . " | ";
	}
	$string = substr( $string, 0, strlen( $string ) -3 );
	return $string;
}
?>
