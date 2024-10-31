<?php

require(__DIR__.'/../../config.php');

global $CFG, $USER, $DB, $OUTPUT, $SITE, $PAGE;

require_once($CFG->dirroot.'/local/demoregister/classes/loginForm.php');
require_once($CFG->dirroot.'/local/demoregister/classes/registrationModel.php');
require_once($CFG->dirroot.'/local/demoregister/classes/authenticationService.php');
require_once($CFG->libdir.'/adminlib.php');

$PAGE->set_url('/local/demoregister/login.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('login');

$header = $SITE->fullname;
$PAGE->set_title(get_string('pluginname', 'local_demoregister'));
$PAGE->set_heading($header);

$model = new registrationModel($DB);
// handle form
$loginForm = new loginForm();
if ($loginForm->is_cancelled()) {
        redirect(new moodle_url('/local/demoregister/login.php')); //clear the form
} elseif($formData = $loginForm->get_data()) {
        $service = new authenticationService($model);
        if ($userData = $service->authenticateUser($formData)) {
            $_SESSION['authUserId'] = $userData->id;
            redirect(new moodle_url('/local/demoregister/setpassword.php'), "Thank your for registering. Please set your password");
        } else {
            redirect(new moodle_url('/local/demoregister/login.php'), "Wrong username or password");
        }
}

echo $OUTPUT->header();
$loginForm->display();
echo $OUTPUT->footer();
?>
