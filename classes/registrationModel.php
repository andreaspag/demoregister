<?php

class registrationModel
{
    protected ?moodle_database $DB = null;

    public function __construct(moodle_database $DB) {
        $this->DB = $DB;
    }

    public function db() {
        return $this->DB;
    }

    public function save(\stdClass $formData): ?\stdClass {
        $record = new \stdClass();
        $record->user_email   = $formData->email;
        $record->user_name    = $formData->name;
        $record->user_surname = $formData->surname;
        $record->user_country = $formData->country;
        $record->user_mobile  = $formData->mobile;
        $record->user_otp     = $this->generateOtp();
        $record->created_at   = date('Y-m-d H:i:s');
        try {
            if($this->DB->insert_record('plugin_demoregister', $record)) {
                return $record;
            }
        } catch(\core\exception\moodle_exception $e) {
            ; // log error?
        }
        return null;

    }

    public function emailExists(string $email): bool {
        return (bool) $this->db()->get_record('plugin_demoregister', ['user_email' => $email]);
    }

    protected function generateOtp(): string {
        return bin2hex(random_bytes(8));
    }

    public function findByEmailAndOtp(string $email, string $otp): ?\stdClass {
        $data = $this->db()->get_record('plugin_demoregister', ['user_email' => $email, 'user_otp' => $otp]);
        return ($data) ?: null;
    }

    public function setUserPassword(string $password, int $userId): bool {
        $dataObject = new \stdClass();
        $dataObject->user_password = $password;
        $dataObject->id = $userId;
        return $this->db()->update_record('plugin_demoregister', $dataObject, false);
    }

}