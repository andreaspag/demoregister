<?php

class registrationService
{
    public function __construct(protected registrationModel $registrationModel){

    }

    public function registerUser(\stdClass $formData): bool {
        $transaction = $this->registrationModel->db()->start_delegated_transaction();
        if($record = $this->registrationModel->save($formData)) {
            $name  = $record->user_name;
            $email = $record->user_email;
            $otp   = $record->user_otp;
            //send email
            $registrationMailer = new mailer();
            try {
                if ($registrationMailer->sendOneTimePassword($name, $email, $otp)) { //commit only if the email was sent
                    $transaction->allow_commit();
                    return true;
                }
                throw new \core\exception\moodle_exception("Unable to send mail");
            } catch (\core\exception\moodle_exception $e) {
                $transaction->rollback($e);
            }
        }
        return false;
    }
}