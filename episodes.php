<?php // episodes.php
require_once 'header.php';
require_once 'functions.php';
require_once 'mysql_login.php';

$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
if( $connection->error ) die( $connection->error );

$query = "SELECT * FROM series LEFT JOIN episodes on series.ID=episodes.serie_ID WHERE series.ID=" . $_GET['selection'];
$result = $connection->query( $query );
$row = $result->fetch_array( MYSQLI_ASSOC );

echo "<h1>" . $row['title'] . " - Season " . $row['season'] . "</h1>";

draw_table_episodes( $result, $result->num_rows );
?>