<?php
require_once(__DIR__.'/../../config.php');
global $PAGE, $OUTPUT;
$PAGE->set_url('/local/demoregister/error.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Registration failed');

$url = (string) new moodle_url('/local/demoregister/index.php');
echo $OUTPUT->header();

echo "<h2>Registration failed. <a href=\"{$url}\">Please try again</a></h2>";

echo $OUTPUT->footer();
