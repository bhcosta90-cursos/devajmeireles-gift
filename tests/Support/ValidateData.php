<?php

declare(strict_types = 1);

namespace Tests\Support;

class ValidateData
{
    public array $data = [];

    public function field(string $field, mixed $value, string | array $rule): self
    {
        if (is_string($rule)) {
            $rule = [$rule];
        }

        $this->data[$field] = [
            'value' => $value,
            'rule'  => $rule,
        ];

        return $this;
    }

    public function run(): array
    {
        return $this->data;
    }

    public static function make(): self
    {
        return new self();
    }
}
