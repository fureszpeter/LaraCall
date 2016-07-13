<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use JsonSerializable;

/**
 * Countries.
 *
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineCountryRepository")
 * @ORM\Cache(usage="READ_ONLY", region="country_region")
 */
class Country implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="countryCode", type="string", length=2, nullable=false)
     */
    private $countrycode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="countryName", type="string", length=45, nullable=false)
     */
    private $countryname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="currencyCode", type="string", length=3, nullable=true)
     */
    private $currencycode;

    /**
     * @var string
     *
     * @ORM\Column(name="isoAlpha3", type="string", length=3, nullable=true)
     */
    private $isoalpha3;

    /**
     * @throws InvalidArgumentException Not allow to create new instance.
     */
    public function __construct()
    {
        throw new InvalidArgumentException('Country can be retrieve only.');
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencycode;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'countryCode'  => $this->getCountrycode(),
            'countryName'  => $this->getCountryname(),
            'currencyCode' => $this->getCountrycode(),
            'isoAlpha3'    => $this->getIsoalpha3(),
        ];
    }

    /**
     * @return string
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * @return string
     */
    public function getCountryname()
    {
        return $this->countryname;
    }

    /**
     * @return string
     */
    public function getIsoalpha3()
    {
        return $this->isoalpha3;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
