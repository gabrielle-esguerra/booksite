<?php
$password = 'abc123';

$bycrypt_password = password_hash($password, PASSWORD_BCRYPT);
echo $bycrypt_password;
	?>