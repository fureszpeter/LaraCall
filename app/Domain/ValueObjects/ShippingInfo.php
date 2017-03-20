<?php
namespace LaraCall\Domain\ValueObjects;

use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\State;

class ShippingInfo
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var Country
     */
    private $countryEntity;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string|null
     */
    private $address2;

    /**
     * @var State
     */
    private $stateEntity;

    /**
     * @param string      $firstName
     * @param string      $lastName
     * @param Country     $countryEntity
     * @param string      $zipCode
     * @param string      $address1
     * @param string|null $address2
     * @param State       $stateEntity
     */
    public function __construct(
        string $firstName,
        string $lastName,
        Country $countryEntity,
        string $zipCode,
        string $address1,
        string $address2 = null,
        State $stateEntity = null
    ) {

        $this->firstName     = $firstName;
        $this->lastName      = $lastName;
        $this->countryEntity = $countryEntity;
        $this->zipCode       = $zipCode;
        $this->address1      = $address1;
        $this->address2      = $address2;
        $this->stateEntity   = $stateEntity;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Country
     */
    public function getCountryEntity(): Country
    {
        return $this->countryEntity;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->address1;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @return State
     */
    public function getStateEntity(): ?State
    {
        return $this->stateEntity;
    }
}
