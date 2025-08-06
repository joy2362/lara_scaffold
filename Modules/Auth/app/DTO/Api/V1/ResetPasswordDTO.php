<?php

namespace Modules\Auth\DTO\Api\V1;

class ResetPasswordDTO
{
    public function __construct(
        public string $email,
        public string $token,
        public string $password,
        public string $confirm_password,
    ) {
    }
}
