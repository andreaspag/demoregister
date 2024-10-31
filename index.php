<?php

require(__DIR__.'/../../config.php');

global $CFG, $USER, $DB, $OUTPUT, $SITE, $PAGE;

require_once($CFG->dirroot.'/local/demoregister/classes/registrationForm.php');
require_once($CFG->dirroot.'/local/demoregister/classes/registrationModel.php');
require_once($CFG->dirroot.'/local/demoregister/classes/registrationService.php');
require_once($CFG->dirroot.'/local/demoregister/classes/mailer.php');
require_once($CFG->libdir.'/adminlib.php');

$PAGE->set_url('/local/demoregister/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');

$header = $SITE->fullname;
$PAGE->set_title(get_string('pluginname', 'local_demoregister'));
$PAGE->set_heading($header);

$model = new registrationModel($DB);
// handle form
$registrationForm = new registrationForm($model);
if ($registrationForm->is_cancelled()) {
        redirect(new moodle_url('/local/demoregister/index.php')); //clear the form
} elseif($formData = $registrationForm->get_data()) {
        $service = new registrationService($model);
        if ($service->registerUser($formData)) {
            redirect(new moodle_url('/local/demoregister/success.php'), "Thank your for registering. Check your email for further instructions");
        } else {
            redirect(new moodle_url('/local/demoregister/error.php'), "Your registration failed. Please try again.");
        }
}

echo $OUTPUT->header();
$registrationForm->display();
echo $OUTPUT->footer();
?>
