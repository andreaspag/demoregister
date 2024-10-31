<?php
require_once(__DIR__.'/../../config.php');
global $PAGE, $OUTPUT, $CFG;
$PAGE->set_url('/local/demoregister/success.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Registration was successful');

$loginUrl = $CFG->wwwroot.'/local/demoregister/login.php';

echo $OUTPUT->header();

echo '<h2>Registration was successful</h2>';
echo "<h4>Use the OTP you received to log in <a href=\"{$loginUrl}\">here</a></h4>";
echo $OUTPUT->footer();
