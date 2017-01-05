<?php
namespace LaraCall\Domain\Registration\Services;

class UserService implements UserServiceInterface
{

    /**
     * @param string $email
     *
     * @return bool
     */
    public function isUserExists(string $email): bool
    {

    }

    /**
     * @param string $email
     *
     * @return string
     */
    public function register(string $email): string
    {
        // TODO: Implement register() method.
    }
}
