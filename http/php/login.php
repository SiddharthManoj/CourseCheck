<?php
require('password.php');

if ((! isset($_POST['un'])) || (! isset($_POST['pwd']))) {
	return;
}

$m = new MongoClient();
$db = $m->db;
$collection = $db->users;
$cursor = $collection->find(array('un' => $_POST['un']));

session_start();

if ($cursor->count() > 0) {
	foreach ($cursor as $doc) {
		if (password_verify($_POST['pwd'], $doc['hash'])) {
			$_SESSION['un'] = $_POST['un'];
			echo '_SUCCESS';
		} else {
			echo 'Incorrect password.';
		}
	}
} else {
	echo 'User not found.';
	return;
}
