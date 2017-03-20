<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;

/**
 * Class EbayPriceListEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineEbayPriceListRepository")
 */
class EbayPriceList extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", nullable=false)
     */
    protected $itemId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $productValue;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $productPrice;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $currency;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $tariffId;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $deleted = false;

    /**
     * @param ItemId $itemId
     * @param string $price
     * @param string $currency
     */
    public function __construct(ItemId $itemId, string $price, string $currency)
    {
        parent::__construct();

        $this->itemId       = $itemId->getItemId();
        $this->productValue = $price;
        $this->currency     = $currency;
    }

    /**
     * @return string
     */
    public function getProductPrice(): string
    {
        return $this->productPrice;
    }

    /**
     * @return int
     */
    public function getTariffId(): int
    {
        return $this->tariffId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemId;
    }

    /**
     * @return string
     */
    public function getProductValue(): string
    {
        return $this->productValue;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }
}
