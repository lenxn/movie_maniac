<?php // header.php
require_once 'functions.php';
require_once 'mysql_login.php';
if( !isset($_SESSION) ) {
	session_start();
}
	
if( !$_SESSION['loggedin'] )
	header( 'Location: http://movie-maniac.ddns.net/login.php' );

$connection = new mysqli( $db_hostname, $db_username, $db_password, $db_database );
if( $connection->error ) die( $connection->error );
$connection->set_charset( 'utf-8' );

$query = "SELECT * from films ORDER BY ID DESC";
$result = $connection->query( $query );
if( !$result ) die( "Query failed" );

?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'/>
<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico"/>
<link rel="stylesheet" href="styles/reset.css"/>
<link rel="stylesheet" href="styles/normalise.css"/>
<link rel="stylesheet" href="styles/base.css"/>

<link rel="stylesheet" href="styles/movie_maniac.css"/>
</head>
<body>
<div id='mysite'>
	<div id='banner'>
	<ul>
		<li>You are logged in as <a href=''><?php echo $_SESSION['username']; ?></a></li>
		<!--<li><a href=''>Messages (0)</a></li>-->
		<li><a href='logout.php'>Logout</a></li>
	</ul>
	<h1>Movie Maniac 2.1</h1>
	</div>
	<div id='container'>
	<div id='navigation-bar'>
		<nav id='globalnav'>
			<ul>
				<li class='menu_button'><a href='index.php'>Home</a></li>
				<li class='menu_button'><a href='#'>Movies</a>
					<ul class='submenu'>
						<li><a href='movie_search.php'>Search</a></li>
						<li><a href='newest_movies.php'>Latest</a></li>
						<!-- <li><a href='top_rated_movies.php'>Top Rated</a></li>-->
						<!-- <li><a href='request_movie.php'>Request</a></li>-->
					</ul>
				</li>		
				<li class='menu_button'><a href='#'>Series</a>
					<ul class='submenu'>
						<!-- <li><a href='serie_search.php'>Search Wizard</a></li> -->
						<li><a href='top_rated_series.php'>Show All</a></li>
					</ul>
				</li>
			</ul>

<?php /*
	 if( isset( $_SESSION['isadmin'] ) )
	{
		 echo "<div class='menu_button'><a href='add_to_table.php'>Add Entry</a></div>" .
			"<div class='menu_button'><a href='edit_entry.php'>Edit Entry</a></div>" .
			"<div class='menu_button'><a href='add_user.php'>Add User</a></div>" .
			"<div class='menu_button'><a href='porn_index.php'>Porn</a></div>";
	}
*/ ?>
		</nav>
	</div>
	
 		<div id='extras'>
			<h1>Recently Added</h1>
			<?php draw_results( $result, 2 ); ?>
		</div>
		<div id='footer'>
			<p>&#169; Movie-Maniac 2015</p>
		</div>
		<div id='main'>
