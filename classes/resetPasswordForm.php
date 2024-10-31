<?php

require_once($CFG->libdir . '/formslib.php');

class resetPasswordForm extends moodleform
{

    public function __construct() {
        parent::__construct();
    }

    public function definition() {
        $form = $this->_form;
        $form->addElement('html', '<div class="p-4">Set your password</div>');
        $form->addElement('password', 'pwd', 'Password');
        $this->add_action_buttons(submitlabel: 'Submit');
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
            'pwd' => 'Please enter your password',
        ];
    }

    protected function prepareForValidation(array &$data): void {
        foreach($data as $key => &$value) {
            $value = trim($value);
        }
    }

}