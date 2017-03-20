<?php

namespace LaraCall\Domain\Services;

interface PinGeneratorService
{
    /**
     * @return string
     */
    public function generate(): string;

    /**
     * @return string
     */
    public function alias(): string;
}
