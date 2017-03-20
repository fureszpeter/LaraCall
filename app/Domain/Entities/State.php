<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use RuntimeException;

/**
 * Class StateEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineStateRepository")
 * @ORM\Cache(usage="READ_ONLY", region="state_region")
 */
class State implements JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="stateCode", type="string", length=2, nullable=false)
     */
    private $stateCode;

    /**
     * @var string
     *
     * @ORM\Column(name="stateName", type="string", length=45, nullable=false)
     */
    private $stateName = '';

    /**
     * @var Country|null
     *
     * @ORM\ManyToOne(targetEntity="country", inversedBy="isoAlpha3")
     * @ORM\JoinColumn(name="countryIsoAlpha3", nullable=true, referencedColumnName="isoAlpha3")
     */
    private $country;

    /**
     * @throws RuntimeException State is retrieve only.
     */
    public function __construct()
    {
        throw new RuntimeException('Country can be retrieve only.');
    }

    /**
     * @return string
     */
    public function getStateName(): string
    {
        return $this->stateName;
    }

    /**
     * @return string
     */
    public function getStateCode(): string
    {
        return $this->stateCode;
    }

    /**
     * @return Country|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'stateCode' => $this->getStateCode(),
            'stateName' => $this->getStateName(),
            'country'   => $this->getCountry(),
        ];
    }
}
