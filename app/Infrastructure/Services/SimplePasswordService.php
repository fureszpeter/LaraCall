<?php
namespace LaraCall\Infrastructure\Services;

use Hash;
use LaraCall\Domain\Services\PasswordService;

class SimplePasswordService implements PasswordService
{
    const PASS_LENGTH = 8;

    /**
     * @return string
     */
    public function generate(): string
    {
        return str_random(self::PASS_LENGTH);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    public function encrypt(string $password): string
    {
        return bcrypt($password);
    }
}
