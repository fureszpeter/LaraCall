<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractEntityWithId.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractEntityWithId extends AbstractEntity
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    final private function setId($id)
    {
        //Do nothing, do not allow id setter.
    }
}
