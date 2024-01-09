<?php

namespace App\Services\Dto;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Alias
{
    public function __construct(
        public string $alias,
    ) {}
}
