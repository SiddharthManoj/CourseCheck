<?php
require('sendgrid-php/sendgrid-php.php');

set_time_limit(0);
$m = new MongoClient();
$db = $m->db;
$sections = $db->sections;
$collection = $sections->find();

while (true) {
	foreach ($collection as $targetSection) {
		$url = 'https://web-app.usc.edu/web/soc/api/classes/' . strtolower($targetSection['dept']) . '/20151';
		$contents = file_get_contents($url);
		$data = json_decode($contents);

		foreach ($data->OfferedCourses->course as $course) {
			$sectionsArray = array();

			if (is_array($course->CourseData->SectionData)) {
				$sectionsArray = $course->CourseData->SectionData;
			} else {
				array_push($sectionsArray, $course->CourseData->SectionData);
			}

			foreach($sectionsArray as $section) {
				if (isset($section->id)) {
					
					if ($section->id == $targetSection['section']) {
						$instructorName = property_exists($section, 'instructor') ? $section->instructor->first_name . ' ' . $section->instructor->last_name : '';
						$info = array('dept' => $data->Dept_Info->abbreviation, 'number' => $course->CourseData->number, 'name' => $course->CourseData->title, 'section' => $section->id, 'prof' => $instructorName, 'start' => $section->start_time, 'end' => $section->end_time, 'seats' => $section->spaces_available, 'taken' => $section->number_registered);
						$uns = $targetSection['uns'];
						$info['uns'] = $uns;
						$sections->remove(array('section' => $targetSection['section']));
						$sections->insert($info);

						if ((int) $targetSection['seats'] - (int) $targetSection['taken'] == 0 && (int) $info['seats'] - (int) $info['taken'] > 0) {
							$sendgrid = new SendGrid('goldani', 'P@ywsE83@q@m5&ykuU5axfs*pn');
							$email = new SendGrid\Email();
							$email->setTos($info['uns']);
							$email->setFrom('noreply@coursecheck.me');
							$email->setFromName('CourseCheck');
							$email->setSubject("A course you're watching has new seats available");
							$email->setText('A course you\'re watching, "' . $info['name'] . '", has new seats available! ');
							$sendgrid->send($email);
						}
					}
				}
			}
		}
	}

	sleep(300);
}
