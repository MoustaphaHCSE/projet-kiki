<?php

namespace App\Dto;
final class UserDto extends Dto
{
    /**
     * @param string $name
     * @param string $email
     * @param string|null $password
     * @param array|string $roles
     */

    public function __construct(
        public string       $name,
        public string       $email,
        public string|null  $password,
        public array|string $roles
    )
    {
    }
}
