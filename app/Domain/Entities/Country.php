<?php
namespace LaraCall\Domain\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use RuntimeException;

/**
 * Countries.
 *
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineCountryRepository")
 * @ORM\Cache(usage="READ_ONLY", region="country_region")
 */
class Country implements JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="isoAlpha3", type="string", length=3, nullable=true)
     */
    private $isoAlpha3;

    /**
     * @var string
     *
     * @ORM\Column(name="countryCode", type="string", length=2, nullable=false, unique=true)
     */
    private $countryCode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="countryName", type="string", length=45, nullable=false)
     */
    private $countryName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="currencyCode", type="string", length=3, nullable=true)
     */
    private $currencyCode;


    /**
     * @var State[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="State", mappedBy="country")
     */
    private $states;

    /**
     * @throws RuntimeException Not allow to create new instance.
     */
    public function __construct()
    {
        throw new RuntimeException('Country can be retrieve only.');
    }

    /**
     * @return ArrayCollection|State[]
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'countryCode'  => $this->getCountryCode(),
            'countryName'  => $this->getCountryName(),
            'currencyCode' => $this->getCountryCode(),
            'isoAlpha3'    => $this->getIsoAlpha3(),
        ];
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getIsoAlpha3()
    {
        return $this->isoAlpha3;
    }
}
