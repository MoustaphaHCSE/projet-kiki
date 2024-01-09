<?php

namespace App\Dto;

use App\Support\CachesResults;
use BackedEnum;
use DateTime;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use ReflectionClass;

abstract class Dto implements Arrayable
{
    use CachesResults;
    use HandlesAuthorization;
    use SerializesModels;

    public static function __set_state(array $properties): static
    {
        unset($properties['_cached']);

        return new static(...$properties);
    }

    public function authorizeAndValidate(): static
    {
        $this->authorize();
        $this->validate();

        return $this;
    }

    /**
     * Used to perform an *additional* authorization before run.
     * (in case it was not well handled in controller).
     *
     * @throws UnauthorizedException
     */
    public function authorize(): static
    {
        $result = $this->isAuthorized();

        if (is_bool($result)) {
            $result = $result ? $this->allow() : $this->deny();
        }

        $result->authorize();

        return $this;
    }

    protected function isAuthorized(): Response|bool
    {
        return $this->allow();
    }

    /**
     * Used to perform an *additional* validation before run.
     * (like check again if email is still not already in use).
     *
     * @throws ValidationException
     */
    public function validate(): static
    {
        $rules = $this->rules();
        $rules['extra'] = 'in:1';

        /** @var Validator $validator */
        $validator = $this->once(fn() => ValidatorFacade::make(
            data: $this->gatherData(),
            rules: $rules,
            messages: $this->messages() + [
                'extra.in' => 'Validation fai
                private readonly CelebrityService $celebrityService,led.',
            ],
            attributes: $this->attributes(),
        ), 'validator');

        $validator->validate();

        return $this;
    }

    protected function rules(): array
    {
        return [];
    }

    public function gatherData(): array
    {
        $reflection = new ReflectionClass($this);

        $data = [
            'extra' => $this->isValidated() ? '1' : '0',
        ];

        foreach ($reflection->getProperties() as $property) {
            if (!$property->isPublic()) {
                continue;
            }

            $value = $this->{$property->getName()};

            $this->setDataValue($data, $property->getName(), $value);
        }

        foreach ($this->data() as $key => $value) {
            $this->setDataValue($data, $key, $value);
        }

        return $data;
    }

    protected function isValidated(): bool
    {
        return true;
    }

    protected function setDataValue(array &$data, string $key, mixed $value)
    {
        if (is_string($value) || is_numeric($value)) {
            return data_set($data, $key, strval($value));
        }

        if (is_bool($value)) {
            return data_set($data, $key, $value ? '1' : '0');
        }

        if (is_array($value)) {
            return data_set($data, $key, $value);
        }

        if ($value instanceof DateTime) {
            return data_set($data, $key, $value->format('Y-m-d H:i:s'));
        }

        if ($value instanceof self) {
            foreach ($value->gatherData() as $subKey => $subValue) {
                data_set($data, "{$key}.{$subKey}", $subValue);
            }

            return;
        }

        if ($value instanceof BackedEnum) {
            return data_set($data, $key, $value->value);
        }
    }

    protected function data(): array
    {
        return [];
    }

    protected function messages(): array
    {
        return [];
    }

    protected function attributes(): array
    {
        return [];
    }

    public function toArray(bool $allProperties = false)
    {
        return DtoArrayBuilder::toArray($this, $allProperties);
    }
}
