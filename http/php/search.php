<?php
if (! (isset($_POST['dept']) && isset($_POST['section']))) {
	return;
}

$dept = $_POST['dept'];
$targetSection = $_POST['section'];
$url = 'https://web-app.usc.edu/web/soc/api/classes/' . $dept . '/20151';
$contents = file_get_contents($url);
$data = json_decode($contents);

$m = new MongoClient();
$db = $m->db;
$users = $db->users;
$sections = $db->sections;
session_start();

foreach ($data->OfferedCourses->course as $course) {
	$found = false;

	$sectionsArray = array();

	if (is_array($course->CourseData->SectionData)) {
		$sectionsArray = $course->CourseData->SectionData;
	} else {
		array_push($sectionsArray, $course->CourseData->SectionData);
	}
	
	foreach ($sectionsArray as $section) {
		if (isset($section->id)) {
			if ($section->id == $targetSection) {
				$found = true;
				$instructorName = property_exists($section, 'instructor') ? $section->instructor->first_name . ' ' . $section->instructor->last_name : '';
				$info = array('dept' => $data->Dept_Info->abbreviation, 'number' => $course->CourseData->number, 'name' => $course->CourseData->title, 'section' => $section->id, 'prof' => $instructorName, 'start' => $section->start_time, 'end' => $section->end_time, 'seats' => $section->spaces_available, 'taken' => $section->number_registered);
				$users->update(array('un' => $_SESSION['un']), array('$addToSet' => array('sections' => $section->id)));
				$matchSections = $sections->findOne(array('section' => $section->id));

				if ($matchSections == NULL) {
					$sections->insert($info);
				}

				$sections->update(array('section' => $section->id), array('$addToSet' => array('uns' => $_SESSION['un'])));
			}
		}
	}

	if ($found) {
		echo '_SUCCESS';
		break;
	}
}
