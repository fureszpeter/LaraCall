<?php
namespace LaraCall\Infrastructure\Services;

use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\ValueObjects\BillingInfo;

class PayPalIpnAddressResolver implements \LaraCall\Domain\Services\PayPalIpnAddressResolver
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @param CountryRepository $countryRepository
     * @param StateRepository   $stateRepository
     */
    public function __construct(CountryRepository $countryRepository, StateRepository $stateRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->stateRepository   = $stateRepository;
    }

    /**
     * @param array $ipn
     *
     * @return BillingInfo
     */
    public function resolve(array $ipn): BillingInfo
    {
        return new BillingInfo(
            $ipn['first_name'],
            $ipn['last_name'],
            $this->countryRepository->getOneBy(['countryCode' => $ipn['address_country_code']]),
            $ipn['address_zip'],
            $ipn['address_city'],
            $ipn['address_street'],
            null,
            $this->stateRepository->findOneBy(['stateCode' => empty($ipn['address_state'])
                    ? null
                    : $ipn['address_state'],
            ])
        );
    }
}
