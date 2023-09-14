<!DOCTYPE html>
<?php
/* Connect to the database */
include'../booksite_mysqli.php';
session_start();
if ((!isset($_SESSION['logged_in'])) || ($_SESSION['logged_in'] != 1)) {
    header("Location: error_login.php");
	exit;
}
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Username's Favourites</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Header -->
  <header>
    <h1>Book Nook</h1>
  </header>

  <!-- Navigation Bar -->
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="books.php">Books</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="favourites.php">Favourites</a></li>
    </ul>
  </nav>

  <!-- Body Content -->
  <section>
    <h2>Username's Favourites</h2>
    <p>edit & delete</p>
  </section>

  <!-- Footer -->
  <footer>
	  <?php
	  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
		  echo '<form action="logout.php" method="post">
		  <button type="submit" name="logoutbutton">Logout</button>
		  </form>';
	  } else {
		  echo "<p>You're currently not logged in</p>";
	  }
	  ?>
    <p>&copy; 2023 Gabrielle's Website. All rights reserved.</p>
  </footer>
</body>
</html>