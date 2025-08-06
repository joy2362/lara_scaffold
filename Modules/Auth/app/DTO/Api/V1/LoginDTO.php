<?php

namespace Modules\Auth\DTO\Api\V1;

class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember = false,
    ) {
    }
}
