<?php

class authenticationService
{
    public function __construct(protected registrationModel $registrationModel){

    }

    public function authenticateUser(\stdClass $formData): ?\stdClass {
        return $this->registrationModel->findByEmailAndOtp($formData->email, $formData->otp);
    }
}