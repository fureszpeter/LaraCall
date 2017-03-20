<?php
namespace A2bApiClient\Api;

use JsonSerializable;

class SubscriptionCreateRequest implements JsonSerializable
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var int
     */
    protected $tariff;

    /**
     * @var string
     */
    protected $uipass;

    /**
     * @var string
     */
    protected $useralias;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $zipcode;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @param string      $pin
     * @param string      $userAlias
     * @param string      $password
     * @param int         $package
     * @param string      $firstName
     * @param string      $lastName
     * @param string      $address
     * @param string      $city
     * @param string      $country
     * @param string      $zipCode
     * @param string      $email
     * @param string      $currency
     * @param string|null $state
     */
    public function __construct(
        $pin,
        $userAlias,
        $password,
        $package,
        $firstName,
        $lastName,
        $address,
        $city,
        $country,
        $zipCode,
        $email,
        $currency,
        $state = null
    ) {
        $this->username  = $pin;
        $this->tariff    = $package;
        $this->uipass    = $password;
        $this->useralias = $userAlias;
        $this->firstname = $firstName;
        $this->lastname  = $lastName;
        $this->address   = $address;
        $this->city      = $city;
        $this->state     = $state;
        $this->country   = $country;
        $this->zipcode   = $zipCode;
        $this->email     = $email;
        $this->currency  = $currency;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @return string
     */
    public function getUipass()
    {
        return $this->uipass;
    }

    /**
     * @return string
     */
    public function getUseralias()
    {
        return $this->useralias;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $reducedArray = array_filter((array) $this, function ($value) {
            return ! is_null($value);
        });

        $keys = array_keys($reducedArray);
        $keys = array_map(function ($key) {
            return trim(str_replace('*', '', $key));
        }, $keys);

        return array_combine($keys, array_values($reducedArray));
    }
}

