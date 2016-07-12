<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use Furesz\TypeChecker\TypeChecker;

/**
 * Class ItemId.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class ItemId extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="item_id", type="string", length=64, nullable=false, unique=true)
     */
    private $itemId;

    /**
     * @var bool
     *
     * @ORM\Column(name="should_monitor", type="boolean", options={"default": true})
     */
    private $shouldMonitor = true;

    /**
     * @param string $itemId
     * @param bool   $shouldMonitor
     */
    public function __construct($itemId, $shouldMonitor = true)
    {
        TypeChecker::assertString($itemId, '$itemId');
        TypeChecker::assertBoolean($shouldMonitor, '$shouldMonitor');

        $this->itemId = $itemId;
        $this->shouldMonitor = $shouldMonitor;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return boolean
     */
    public function isShouldMonitor()
    {
        return $this->shouldMonitor;
    }

    /**
     * @param boolean $shouldMonitor
     *
     * @return $this
     */
    public function setShouldMonitor($shouldMonitor)
    {
        TypeChecker::assertBooleaKn($shouldMonitor, '$shouldMonitor');

        $this->shouldMonitor = $shouldMonitor;

        return $this;
    }
}
