<?php

require_once($CFG->libdir . '/formslib.php');

class loginForm extends moodleform
{

    public function __construct() {
        parent::__construct();
    }

    public function definition() {
        $form = $this->_form;
        $form->addElement('html', '<div class="p-4">Fill in the form to log in</div>');
        $form->addElement('text', 'email', 'email address');
        $form->addElement('password', 'otp', 'One time password');
        $this->add_action_buttons(submitlabel: 'Login');
    }

    public function validation($data, $files): array {
        $errors = array();
        $required = $this->requiredFields();
        $this->prepareForValidation($data);

        foreach($required as $requiredfield => $message) {
            if (empty($data[$requiredfield])) {
                $errors[$requiredfield] = $message;
            }
        }
        return $errors;
    }

    protected function requiredFields(): array {
        return [
            'email' => 'Please type your email address',
            'otp' => 'Please enter your password',
        ];
    }

    protected function prepareForValidation(array &$data): void {
        foreach($data as $key => &$value) {
            $value = trim($value);
        }
    }

}