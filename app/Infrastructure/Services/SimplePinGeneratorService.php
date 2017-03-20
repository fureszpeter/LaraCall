<?php
namespace LaraCall\Infrastructure\Services;

use LaraCall\Domain\Services\PinGeneratorService;

class SimplePinGeneratorService implements PinGeneratorService
{

    /**
     * @return string
     */
    public function generate(): string
    {
        return $this->generateRandomNumber(10);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function generateRandomNumber(int $length): string
    {
        $randomNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= mt_rand(0, 9);
        }

        return (string) $randomNumber;
    }

    /**
     * @return string
     */
    public function alias(): string
    {
        return $this->generateRandomNumber(15);
    }
}
