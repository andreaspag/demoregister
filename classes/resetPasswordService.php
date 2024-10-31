<?php

class resetPasswordService
{
    public function __construct(protected registrationModel $registrationModel) {

    }

    public function setUserPassword(?\stdClass $formData, int $userId): bool {
        if (empty($formData) || empty($userId)) {
            return false;
        }

        try {
            return $this->registrationModel->setUserPassword($formData->pwd, $userId);
        } catch(\core\exception\moodle_exception $e) {
            return false;
        }
    }
}