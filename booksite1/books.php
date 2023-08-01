<?php
/* Connect to the database */
include'../booksite_mysqli.php';

/* SQL query to return books in the database */
$booksquery = "SELECT * FROM Books";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Books</title>
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
    <div class="book-list">
		<?php
        $booksqueryresult = mysqli_query($conn, $booksquery);
		while ($row = mysqli_fetch_array($booksqueryresult)) {
                    foreach ($booksqueryresult as $row) {
                        echo "<div class='book-list-item'><img src='images/" . $row['Cover'] . "'/>";
                        echo "<h3>" . $row['Title'] . "</h3><p>by " . $row['Author'] . "<br>Publisher: " . $row['Pub'] . "<br>Year Published: " . $row['PubYr'] . "</p></div>";
                }
		}
        ?>
  </div>
	  </section>
  
  <!-- Footer -->
  <footer>
    <p>&copy; 2023 Your Website. All rights reserved.</p>
  </footer>
</body>
</html>