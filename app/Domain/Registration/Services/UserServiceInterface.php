<?php

namespace LaraCall\Domain\Registration\Services;

/**
 * Interface UserServiceInterface
 * @package LaraCall\Domain\Services
 */
interface UserServiceInterface
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function isUserExists(string $email): bool;

    /**
     * @param string $email
     *
     * @return string
     */
    public function register(string $email) : string;
}
