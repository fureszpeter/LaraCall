<?php

namespace LaraCall\Domain\Services;

interface EbayUsernameTokenResolver
{
    public function resolveUsername2Token(string $username): string;

    public function resolveToken2Username(string $token): string;
}
