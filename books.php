<?php
/* Connect to the database */
include '../booksite_mysqli.php';
session_start();

// Function to fetch authors and publishers
function getAuthors($conn) {
    $authors = array();
    $query = "SELECT AuthorID, CONCAT(Fname, ' ', Lname) AS AuthorName FROM Authors";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $authors[$row['AuthorID']] = $row['AuthorName'];
        }
    }
    return $authors;
}

function getPublishers($conn) {
    $publishers = array();
    $query = "SELECT PubID, Name FROM Publishers";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $publishers[$row['PubID']] = $row['Name'];
        }
    }
    return $publishers;
}

// Function to check for blank input and maximum value
function checkInput($value, $fieldName) {
    if (empty($value)) {
        echo "<p>Error: $fieldName cannot be blank.</p><br>";
        return false;
    }
    
    if ($fieldName === 'Year Published' && !is_numeric($value)) {
        echo "<p>Error: $fieldName must be a number.</p><br>";
        return false;
    }
    
    if ($fieldName === 'Year Published' && ($value < 0 || $value > 9999)) {
        echo "<p>Error: $fieldName must be between 0 and 9999.</p><br>";
        return false;
    }
    
    return true;
}


$authors = getAuthors($conn);
$publishers = getPublishers($conn);
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
      function displayBooks($result, $authors, $publishers, $conn) {
        if ($result && mysqli_num_rows($result) > 0) {
            // Inside the while loop for displaying books
            while ($row = mysqli_fetch_array($result)) {
                echo "<div class='book-list-item'><img src='images/" . $row['Cover'] . "' alt='" . $row['Title'] . "'>";

                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
                    echo "<form method='POST' action='books.php'>"; // Create a form for editing
                    echo "<input type='hidden' name='book_id' value='" . $row['BookID'] . "'>";
                    echo '<input type="text" name="title" value="' . $row['Title'] . '"><br>';

                    // Dropdown for authors with the current author selected
                    echo '<label for="author_id">Author:</label>';
                    echo '<select name="author_id" id="author_id">';
                    
                    foreach ($authors as $authorID => $authorName) {
                        $selected = ($authorID == $row['AuthorID']) ? "selected" : "";
                        echo "<option value='" . $authorID . "' $selected>" . $authorName . "</option>";
                    }
                    echo "</select><br>";

                    // Dropdown for publishers with the current publisher selected
                    echo '<label for="publisher_id">Publisher:</label>';
                    echo '<select name="publisher_id" id="publisher_id">';
                    
                    foreach ($publishers as $publisherID => $publisherName) {
                        $selected = ($publisherID == $row['PubID']) ? "selected" : "";
                        echo "<option value='" . $publisherID . "' $selected>" . $publisherName . "</option>";
                    }
                    echo "</select><br>";

                    echo '<label for="year_published">Year Published:</label>';
                    echo '<input type="text" name="year_published" value="' . $row['PubYr'] . '"><br>';
                    echo "<button type='submit' name='edit_button'>Edit</button></form>";
                } else {
                    echo "<h3>" . $row['Title'] . "</h3><p>by " . $row['Fname'] . " " . $row['Lname'] .
                        "<br>Publisher: " . $row['Name'] . "<br>Year Published: " . $row['PubYr'] . "</p>";
                }

                echo "</div>";
            }
        }
      }

      if (isset($_POST['edit_button'])) {
          $bookID = $_POST['book_id'];
          $newTitle = mysqli_real_escape_string($conn, $_POST['title']);
          $newAuthorID = mysqli_real_escape_string($conn, $_POST['author_id']);
          $newPublisherID = mysqli_real_escape_string($conn, $_POST['publisher_id']);
          $newYearPublished = mysqli_real_escape_string($conn, $_POST['year_published']);

           // Check for blank input for Title and Image Name
		  if (checkInput($newTitle, 'Title') && checkInput($newYearPublished, 'Year Published')) {
			  if (checkInput($newYearPublished, 'Year Published')) {
            // Update the database
          $updateQuery = "UPDATE Books SET Title = ?, AuthorID = ?, PubID = ?, PubYr = ? WHERE BookID = ?";
          $stmt = mysqli_prepare($conn, $updateQuery);
          mysqli_stmt_bind_param($stmt, "siisi", $newTitle, $newAuthorID, $newPublisherID, $newYearPublished, $bookID);

          if (mysqli_stmt_execute($stmt)) {
              echo "<p>Book details updated successfully.</p><br>";
          } else {
              echo "<p>Error updating book details: " . mysqli_error($conn) . "</p><br>";
          }
          mysqli_stmt_close($stmt);
      }
		  }
		  }
		  
      if (isset($_POST['add_button'])) {
    // Retrieve the maximum BookID from the Books table
    $maxBookIDQuery = "SELECT MAX(BookID) AS MaxBookID FROM Books";
    $maxBookIDResult = mysqli_query($conn, $maxBookIDQuery);

    if ($maxBookIDResult && mysqli_num_rows($maxBookIDResult) > 0) {
        $row = mysqli_fetch_assoc($maxBookIDResult);
        $newBookID = $row['MaxBookID'] + 1;
    } else {
        // If no books exist yet, start with BookID 1
        $newBookID = 1;
    }

    $newTitle = mysqli_real_escape_string($conn, $_POST['new_title']);
    $newAuthorID = mysqli_real_escape_string($conn, $_POST['new_author_id']);
    $newPublisherID = mysqli_real_escape_string($conn, $_POST['new_publisher_id']);
    $newYearPublished = mysqli_real_escape_string($conn, $_POST['new_year_published']);
    $newImageName = mysqli_real_escape_string($conn, $_POST['new_image_name'] . ".jpg");

    // Check for blank input for Title and Image Name
    if (checkInput($newTitle, 'Title') && checkInput($newYearPublished, 'Year Published') && checkInput($newImageName, 'Image Name')) {
        // Insert the new book into the database with the new BookID
        $insertQuery = "INSERT INTO Books (BookID, Title, AuthorID, PubID, PubYr, Cover) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "isiiis", $newBookID, $newTitle, $newAuthorID, $newPublisherID, $newYearPublished, $newImageName);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>New book added successfully.</p><br>";
        } else {
            echo "<p>Error adding new book: " . mysqli_error($conn) . "</p><br>";
        }
        mysqli_stmt_close($stmt);
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
          displayBooks($searchresult, $authors, $publishers, $conn);
          
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
          displayBooks($sortresult, $authors, $publishers, $conn);
      
      } else {
          $booksquery = "SELECT * FROM Books, Authors, Publishers
          WHERE Books.AuthorID = Authors.AuthorID
          AND Books.PubID = Publishers.PubID";
          $booksqueryresult = mysqli_query($conn, $booksquery);
          displayBooks($booksqueryresult, $authors, $publishers, $conn);
      }

      if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
          echo '<div class="book-list-item">
              <h2>Add a New Book</h2>
              <form method="POST">
                  <label for="new_title">Title:</label>
                  <input type="text" id="new_title" name="new_title" required><br>

                  <label for="new_author_id">Author:</label>
                  <select name="new_author_id" id="new_author_id" required>
                      <option value="" disabled selected>Select an author</option>';
                      // Loop through authors to populate the dropdown
                      foreach ($authors as $authorID => $authorName) {
                          echo "<option value='" . $authorID . "'>" . $authorName . "</option>";
                      }
                      echo '</select><br>

                  <label for="new_publisher_id">Publisher:</label>
                  <select name="new_publisher_id" id="new_publisher_id" required>
                      <option value="" disabled selected>Select a publisher</option>';
                      // Loop through publishers to populate the dropdown
                      foreach ($publishers as $publisherID => $publisherName) {
                          echo "<option value='" . $publisherID . "'>" . $publisherName . "</option>";
                      }
                      echo '</select><br>

                  <label for="new_year_published">Year Published:</label>
                  <input type="text" id="new_year_published" name="new_year_published" required><br>

                  <label for="new_image_name">Image Name:</label>
                  <input type="text" id="new_image_name" name="new_image_name" required><br>

                  <button type="submit" name="add_button">Add Book</button>
              </form>
          </div>';
      }
      ?>
    </div>
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
