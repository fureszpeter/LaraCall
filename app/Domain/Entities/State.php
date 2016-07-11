<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * States
 *
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineStateRepository")
 * @ORM\Cache(usage="READ_ONLY", region="state_region")
 */
class State
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="abbrev", type="string", length=2, nullable=false)
     */
    private $abbrev;

    /**
     * @throws InvalidArgumentException Not allow to create new instance.
     */
    public function __construct()
    {
        throw new InvalidArgumentException('State can be retrieve only.');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAbbrev()
    {
        return $this->abbrev;
    }
}

