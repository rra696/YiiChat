<?php
declare(strict_types=1);

namespace app\utils;

use RuntimeException;

class PasswordHasher
{
    private int $memoryCost;

    public function __construct(int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
        $this->memoryCost = $memoryCost;
    }

    public function hash(string $password): string
    {
        if (empty(trim($password))) {
            throw new RuntimeException('Password id empty.');
        }

        $hash = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => $this->memoryCost]);

        if ($hash === null) {
            throw new RuntimeException('Invalid hash algorithm.');
        }

        if ($hash === false) {
            throw new RuntimeException('Unable to generate hash');
        }

        return $hash;
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
