<?php
namespace LaraCall\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\State;

/**
 * Class UserContactDetails.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Embeddable()
 */
class UserContactDetails
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name",length=128, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", length=128, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", length=128, nullable=true)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(name="state", length=128, nullable=true)
     */
    protected $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", length=16, nullable=true)
     */
    protected $zipCode;

    /**
     * @var string
     * @ORM\Column(name="address1", type="string", length=254, nullable=true)
     */
    protected $address1;

    /**
     * @var string
     * @ORM\Column(name="address2", type="string", length=254, nullable=true)
     */
    protected $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", nullable=true)
     */
    protected $phoneNumber;

    /**
     * @param string  $firstName
     * @param string  $lastName
     * @param string  $zipCode
     * @param string  $address1
     * @param string  $address2
     * @param string  $phoneNumber
     * @param Country $country
     * @param State   $state
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $zipCode,
        string $address1,
        string $address2,
        string $phoneNumber,
        Country $country = null,
        State $state = null
    ) {
        $this->firstName   = $firstName;
        $this->lastName    = $lastName;
        $this->zipCode     = $zipCode;
        $this->address1    = $address1;
        $this->address2    = $address2;
        $this->phoneNumber = $phoneNumber;
        $this->country     = $country ? $country->getCountryname() : null;
        $this->state       = $state ? $state->getAbbrev() : null;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}
