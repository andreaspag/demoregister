<?php

require(__DIR__.'/../../config.php');

global $CFG, $USER, $DB, $OUTPUT, $SITE, $PAGE;

require_once($CFG->dirroot.'/local/demoregister/classes/resetPasswordForm.php');
require_once($CFG->dirroot.'/local/demoregister/classes/registrationModel.php');
require_once($CFG->dirroot.'/local/demoregister/classes/resetPasswordService.php');
require_once($CFG->libdir.'/adminlib.php');

if (!isset($_SESSION['authUserId'])) {
    header('location:http://www.moodle.org', true, 301);
    exit(0);
}

$PAGE->set_url('/local/demoregister/setpassword.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('login');

$header = $SITE->fullname;
$PAGE->set_title(get_string('pluginname', 'local_demoregister'));
$PAGE->set_heading($header);

$model = new registrationModel($DB);
// handle form
$resetPasswordForm = new resetPasswordForm();
if ($resetPasswordForm->is_cancelled()) {
        redirect(new moodle_url('/local/demoregister/setpassword.php')); //clear the form
} elseif(($formData = $resetPasswordForm->get_data()) && isset($_SESSION['authUserId'])) {
        $service = new resetPasswordService($model);
        if ($userData = $service->setUserPassword($formData, $_SESSION['authUserId'])) {
            redirect(new moodle_url('/local/demoregister/done.php'), "Thank your for registering. Please set your password");
        } else {
            redirect(new moodle_url('/local/demoregister/setpassword.php'), "An error occured while attempting to set your password.");
        }
}

echo $OUTPUT->header();
$resetPasswordForm->display();
echo $OUTPUT->footer();
?>
