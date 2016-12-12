<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use Furesz\TypeChecker\TypeChecker;
use JsonSerializable;
use LaraCall\Domain\ValueObjects\eBay\EbayItemIdVO;

/**
 * Class ItemId.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineEbayListingRepository")
 */
class Item extends AbstractEntity implements JsonSerializable
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
     * @var string
     */
    private $title;

    /**
     * @param EbayItemIdVO $itemId
     * @param string       $title
     * @param float        $value
     * @param string       $sellerAccountName
     * @param bool         $shouldMonitor
     */
    public function __construct(
        EbayItemIdVO $itemId,
        $title,
        $value,
        $sellerAccountName,
        $shouldMonitor = true
    ) {
        TypeChecker::assertBoolean($shouldMonitor, '$shouldMonitor');
        TypeChecker::assertString($title, '$title');
        TypeChecker::assertString($sellerAccountName, '$sellerAccountName');
        TypeChecker::assertDouble($value, '$value');

        parent::__construct();

        $this->itemId = (string) $itemId;
        $this->setShouldMonitor($shouldMonitor);
        $this->setSellerAccountName($sellerAccountName);
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'id'         => $this->getItemId(),
            'title'      => $this->getTitle(),
            'value'      => $this->getValue(),
            'sellerName' => $this->getSellerAccountName(),
            'monitor'    => $this->isShouldMonitor(),
        ];
    }

    /**
     * @return EbayItemIdVO
     */
    public function getItemId()
    {
        return new EbayItemIdVO($this->itemId);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return floatval($this->value);
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
     * @return string
     */
    public function getSellerAccountName()
    {
        return $this->sellerAccountName;
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
}
