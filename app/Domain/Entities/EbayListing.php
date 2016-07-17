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
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineEbayListingRepository")
 */
class EbayListing extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @var string
     *
     * @ORM\Column(type="decimal", precision=19, scale=4, nullable=false, options={"default": 0})
     */
    private $value;

    /**
     * @param string $itemId
     * @param float       $value
     * @param string $sellerAccountName
     * @param bool   $shouldMonitor
     */
    public function __construct($itemId, $value, $sellerAccountName, $shouldMonitor = true)
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
     * @return float
     */
    public function getValue()
    {
        return floatval($this->value);
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
     * @param float $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        TypeChecker::assertDouble($value, '$value');

        $this->value = (string) $value;

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
