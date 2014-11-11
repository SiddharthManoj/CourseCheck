<?php
session_start();

if (! isset($_SESSION['un'])) {
	echo '_FAILURE';
	return;
}

$contents = file_get_contents($url);
$data = json_decode($contents);
$m = new MongoClient();
$db = $m->db;
$users = $db->users;
$sections = $db->sections;
$result = $users->findOne(array('un' => $_SESSION['un']));

$final = array();

foreach ($result['sections'] as $section) {
	$match = $sections->findOne(array('section' => $section));
	unset($match['uns']);
	unset($match['_id']);

	if ($match != NULL) {
		array_push($final, $match);
	}
}

echo json_encode($final);
