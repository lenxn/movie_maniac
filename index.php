<?php 
// Movie-Maniac 2.1
// movie-maniac.ddns.net/index.php
require_once 'auth.php';
require_once 'header.php';
require_once 'mysql_login.php';

echo "<head><title>Movie Maniac</title></head>";
echo "<p>Welcome to Movie-Maniac, " . $_SESSION['name'] . "!</p><p>You are now logged in as <em>" . $_SESSION['username'] . "</em></p>";
// echo "<p>In case you encounter any buggs or problems, please make use of the <a href=''>Report a Problem</a> function</p>";
?>

</div>
</div>
</body>
</html>
