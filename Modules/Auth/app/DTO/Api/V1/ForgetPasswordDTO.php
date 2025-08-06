<?php

namespace Modules\Auth\DTO\Api\V1;

class ForgetPasswordDTO
{
    public function __construct(
        public string $email,
    ) {
    }
}
