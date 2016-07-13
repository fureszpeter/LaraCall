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
class EbayListing extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="item_id", type="string", length=64, nullable=false, unique=true)
     */
    private $itemId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $sellerAccountName;

    /**
     * @var bool
     *
     * @ORM\Column(name="should_monitor", type="boolean", options={"default": true})
     */
    private $shouldMonitor = true;

    /**
     * @param string $itemId
     * @param string $sellerAccountName
     * @param bool   $shouldMonitor
     */
    public function __construct($itemId, $sellerAccountName, $shouldMonitor = true)
    {
        TypeChecker::assertString($itemId, '$itemId');

        parent::__construct();

        $this->itemId = $itemId;
        $this->setShouldMonitor($shouldMonitor);
        $this->setSellerAccountName($sellerAccountName);
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return string
     */
    public function getSellerAccountName()
    {
        return $this->sellerAccountName;
    }

    /**
     * @return bool
     */
    public function isShouldMonitor()
    {
        return $this->shouldMonitor;
    }

    /**
     * @param bool $shouldMonitor
     *
     * @return $this
     */
    public function setShouldMonitor($shouldMonitor)
    {
        TypeChecker::assertBoolean($shouldMonitor, '$shouldMonitor');

        $this->shouldMonitor = $shouldMonitor;

        return $this;
    }

    /**
     * @param string $sellerAccountName
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function setSellerAccountName($sellerAccountName)
    {
        TypeChecker::assertString($sellerAccountName, '$sellerAccountName');

        $this->sellerAccountName = $sellerAccountName;

        return $this;
    }
}
