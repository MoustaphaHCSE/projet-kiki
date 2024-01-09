<?php

namespace App\Dto;


use ReflectionClass;
use ReflectionParameter;
use ReflectionProperty;
use RuntimeException;

class DtoArrayBuilder
{
    private function __construct()
    {
    }

    public static function toArray(Dto $dto, bool $allProperties): array
    {
        $data = [];

        foreach (self::getParameters(get_class($dto), $allProperties) as $parameter) {
            $data[$parameter->getName()] = $dto->{$parameter->getName()};
        }

        return $data;
    }
    
    /**
     * Returns the constructor parameter of the specified DTO class
     *
     * @param string $class
     * @return ReflectionParameter[]
     */
    protected static function getParameters(string $class, bool $allProperties = false): array
    {
        $reflection = new ReflectionClass($class);

        if (! $reflection->isInstantiable()) {
            throw new RuntimeException(
                'Cannot build an abstract Dto from array.',
            );
        }

        if ($allProperties) {
            return $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        }

        return $reflection->getConstructor()?->getParameters();
    }
}
