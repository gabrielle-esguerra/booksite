<!DOCTYPE html>
<?php
/* Connect to the database */
include'../booksite_mysqli.php';
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
	  <h2>Login or Create account</h2>
	  <div class='forms'>
		  <form name='login_form' id='login_form' method='post' action='process_login.php'>
			  <label for="username">Username:</label>
			  <input type="text" id="username" name="username" placeholder="Username"><br>
			  <label for="password">Password:</label>
			  <input type="password" id="password" name="password" placeholder="Password"><br><br>
			  <button type="submit">Log In</button>
		  </form>
		  <form name='createacc_form' id='createacc_form' method='post' action='login.php'>
			  <label for="username">Username:</label>
			  <input type="text" id="username" name="username" placeholder="Username" required><br>
			  <label for="password">Password:</label>
			  <input type="password" id="password" name="password" placeholder="Password" required><br><br>
			  <button type="submit" value="Insert">Create account</button>
		  </form>
	  </div>
	  <div class='centered'>
	  <?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize input data (you should enhance this for security)
    $username = htmlspecialchars($username);
    
    // Check if username length is too long
    if (strlen($username) > 30) {
        echo "<p>Username is too long. Please choose a username with 30 characters or less.</p>";
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

        // Check if the username already exists
        $checkUsername = $conn->prepare("SELECT * FROM Users WHERE username = ?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();
        $result = $checkUsername->get_result();

        if ($result->num_rows > 0) {
            echo "<p>Username already exists. Please choose a different username.</p>";
        } else { // Get the ID of the latest entry
            $latestId = 0;
            $result = $conn->query("SELECT MAX(UserID) AS maxId FROM Users");
            if ($result) {
                $row = $result->fetch_assoc();
                $latestId = $row['maxId'];
                $result->free();
            }
            $newId = $latestId + 1; // Increment the latest ID by one

            // Insert data into the users table with the new ID
            $sql = "INSERT INTO Users (UserID, username, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("iss", $newId, $username, $password);
                if ($stmt->execute()) {
                    echo "<p>Your new account has been created! You can now use it to login</p>";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>

	  </div>
	   </section>

  <!-- Footer -->
  <footer>
	  <?php
	  session_start();
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