<?php
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('root', new \admin_category('local_demoregister', get_string('pluginname', 'local_demoregister')));
    $ADMIN->add('local_demoregister', new \admin_externalpage('User Registration', get_string('register', 'local_demoregister'), new moodle_url('/local/demoregister/index.php')));
    $ADMIN->add('localplugins', new \admin_category('demoregister', get_string('pluginname', 'local_demoregister')));
}