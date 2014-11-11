<?php
require('password.php');

if ((! isset($_POST['un'])) || (! isset($_POST['pwd']))) {
	return;
}

if (! filter_var($_POST['un'], FILTER_VALIDATE_EMAIL)) {
	echo 'Email must be valid.';
	return;
}

if ($_POST['pwd'] == '') {
	echo 'Password must consist of at least one character.';
	return;
}

$m = new MongoClient();
$db = $m->db;
$collection = $db->users;

if ($collection->find(array('un' => $_POST['un']))->count() > 0) {
	echo 'The email you specified is already tied to an account.';
	return;
}

$hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
$user = array('un' => $_POST['un'], 'hash' => $hash);
$collection->insert($user);
