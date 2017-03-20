<?php
namespace LaraCall\Factories;

use Illuminate\Contracts\Config\Repository;
use LaraCall\Domain\PayPal\FalsePayPalIpnValidator;
use LaraCall\Domain\PayPal\GuzzlePayPalIpnValidator;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Domain\PayPal\TruePayPalIpnValidator;

class PayPalIpnValidatorFactory
{
    /**
     * @var Repository
     */
    private $configRepository;

    /**
     * @param Repository $configRepository
     */
    public function __construct(Repository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @return PayPalIpnValidator
     */
    public function make()
    {
        switch ($this->configRepository->get('laracall.paypal.ipn_driver', 'default')) {
            case 'true':
                return app()->make(TruePayPalIpnValidator::class);

                break;
            case 'false':
                return app()->make(FalsePayPalIpnValidator::class);

                break;
            default:

                return app()->make(GuzzlePayPalIpnValidator::class);
        }
    }
}
