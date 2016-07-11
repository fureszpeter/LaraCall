<?php
namespace LaraCall\Domain\Factories;

use ValueObjects\Money\Money;

/**
 * Class MoneyFactory.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class MoneyFactory
{
    /**
     * @param int $amount
     *
     * @return Money
     */
    public static function make($amount)
    {
        return Money::fromNative($amount * 100, 'USD');
    }
}
