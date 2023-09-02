<?php
/* Connect to the database */
include'../booksite_mysqli.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	  <div class='forms'>
  <form method="GET">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" placeholder="Title, Author, or Publisher">
    <button type="submit">Search</button>
	  </form>

	  <form method="GET">
    <label for="sort">Sort By:</label>
    <select name="sort" id="sort">
      <option value="title">Book Title</option>
      <option value="auth_lname">Author's Last Name</option>
      <option value="pub_name">Publisher's Name</option>
	</select>	
    <button type="submit" value="sort" name="sortbutton">Sort</button>
		  </form>
	  
	  <form method="GET">
    <button type="submit" name="showall">Show All Books</button>
  </form>
		  </div>

	  <div class="book-list">
  <?php
	function displayBooks($result) {
		if ($result && mysqli_num_rows($result) > 0) {
			echo "<div class='book-list'>";
			while ($row = mysqli_fetch_array($result)) {
				echo "<div class='book-list-item'><img src='images/" . $row['Cover'] . "'/>";
				echo "<h3>" . $row['Title'] . "</h3><p>by " . $row['Fname'] . " " . $row['Lname'] .
					"<br>Publisher: " . $row['Name'] . "<br>Year Published: " . $row['PubYr'] . "</p></div>";
			}
			echo "</div>";
		} else {
			echo "No books found";
		}
	}
	
	if (isset($_GET['search'])) {
		$search = $_GET['search'];
		$booksearch = "SELECT * FROM Books
		JOIN Authors ON Books.AuthorID = Authors.AuthorID 
		JOIN Publishers ON Books.PubID = Publishers.PubID
		WHERE Books.Title LIKE '%$search%' OR Authors.Fname LIKE '%$search%' 
		OR Authors.Lname LIKE '%$search%' OR Publishers.Name LIKE '%$search%'";
		
		$searchresult = mysqli_query($conn, $booksearch);
		displayBooks($searchresult);
	
	} else if (isset($_GET['sort'])) {
		$sort = $_GET['sort'];
		$booksort = "SELECT * FROM Books
		JOIN Authors ON Books.AuthorID = Authors.AuthorID
		JOIN Publishers ON Books.PubID = Publishers.PubID
		ORDER BY
		CASE WHEN '$sort' = 'auth_lname' THEN Authors.Lname END,
		CASE WHEN '$sort' = 'title' THEN Books.Title END,
		CASE WHEN '$sort' = 'pub_name' THEN Publishers.Name END";
		
		$sortresult = mysqli_query($conn, $booksort);
		displayBooks($sortresult);
	
	} else {
		$booksquery = "SELECT * FROM Books, Authors, Publishers
		WHERE Books.AuthorID = Authors.AuthorID
		AND Books.PubID = Publishers.PubID";
		$booksqueryresult = mysqli_query($conn, $booksquery);
		displayBooks($booksqueryresult);
	}
	?>
		  </div>
		  </section>
		  
  <!-- Footer -->
  <footer>
    <p>&copy; 2023 Gabrielle's Website. All rights reserved.</p>
  </footer>
</body>
</html>