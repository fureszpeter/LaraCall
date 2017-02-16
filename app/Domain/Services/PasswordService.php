<?php

namespace LaraCall\Domain\Services;

interface PasswordService
{
    /**
     * @return string
     */
    public function generate(): string;

    /**
     * @param string $password
     *
     * @return string
     */
    public function encrypt(string $password): string;
}
