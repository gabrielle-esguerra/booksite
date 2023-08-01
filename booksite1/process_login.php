<?php
session_start();
/* Connect to the database */
include '../booksite_mysqli.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    $login_query = "SELECT password FROM users WHERE username = '". $user."'";
    $login_result = mysqli_query($conn, $login_query);
    $login_record = mysqli_fetch_assoc($login_result);
	
	$hash = $login_record['password'];
	
	if (password_verify($pass, $hash)) {
            $_SESSION['logged_in'] = 1;
	}
}
header("Location: favourites.php");
exit;
?>