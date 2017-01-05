<?php
namespace LaraCall\Domain\Registration\Services;

use UnexpectedValueException;

class RegistrationService
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param string $email
     *
     * @throws UnexpectedValueException If user already registered.
     *
     * @return string
     */
    public function register(string $email): string
    {
        if ($this->userService->isUserExists($email)) {
            throw new UnexpectedValueException(
                sprintf('User with email already exists. [email: %s]', $email)
            );
        }

        $this->userService->register();
    }
}
