<?php
session_start();
/* Connect to the database */
include'../booksite_mysqli.php';

$_SESSION['logged_in'] = 0;
	
if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);
	
	$login_query = "SELECT Password FROM Users WHERE Username = '" . $user . "'";
	$login_result = mysqli_query($conn, $login_query);
	$login_record = mysqli_fetch_assoc($login_result);

	$hash = $login_record['Password'];
	
	if (password_verify($pass, $hash)) {
            $_SESSION['logged_in'] = 1;
	}
}
header("Location: favourites.php");
exit;
?>