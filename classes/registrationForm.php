<?php

require_once($CFG->libdir . '/formslib.php');

class registrationForm extends moodleform
{

    protected ?registrationModel $registrationModel = null;

    public function __construct(registrationModel $registrationModel) {
        $this->registrationModel = $registrationModel;
        parent::__construct();
    }

    public function definition() {
        $form = $this->_form;
        $form->addElement('header', 'general', \get_string('register', 'local_demoregister'));
        $form->addElement('html', '<div class="p-4">Fill in the form to register</div>');
        $form->addElement('text', 'email', 'Your email address');
        $form->addElement('text', 'name', 'Your first name');
        $form->addElement('text', 'surname', 'Your last name');
        $form->addElement('text', 'country', 'Country of residence');
        $form->addElement('text', 'mobile', 'Mobile phone number');
        $this->add_action_buttons(submitlabel: 'Register');
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
        if (empty($errors['mobile']) && !preg_match('#^[0-9]+$#', $data['mobile'])) {
            $errors['mobile'] = 'Invalid mobile number';
        }
        if (empty($errors['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }
        if (empty($errors['email']) && $this->registrationModel->emailExists($data['email'])) {
            $errors['email'] = 'This email address already exists';
        }
        return $errors;
    }

    protected function requiredFields(): array {
        return [
            'email' => 'Please type your email address',
            'name' => 'Please type your name',
            'surname' => 'Please type your surname',
            'country' => 'Please type your country',
            'mobile' => 'Please type your mobile number',
        ];
    }

    protected function prepareForValidation(array &$data): void {
        foreach($data as $key => &$value) {
            $value = trim($value);
        }
    }


}