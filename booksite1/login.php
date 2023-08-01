<!DOCTYPE html>
<html>
<head>
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
    <h2>Login Here</h2>
	  <div class="container">
	 	<form name='login_form' id='login_form' method='post' action='process_login.php'>
			<label for='username'>Username:</label>
  			<input type='text' name='username'><br>

  			<label for='password'>Password:</label>
  			<input type='password' name='password'><br>

  			<input type='submit' name='submit' id='submit' value='Log In'><br>
		</form>
  </div>
    <p></p>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2023 Your Website. All rights reserved.</p>
  </footer>
</body>
</html>