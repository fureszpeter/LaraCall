<?php
namespace LaraCall\Infrastructure\Services\Ebay\ValueObjects;

use UnexpectedValueException;

class ItemId
{
    /**
     * @var string
     */
    private $itemId;

    /**
     * @param string $itemId
     */
    public function __construct(string $itemId)
    {
        $this->setItemId($itemId);
    }

    public function __toString()
    {
        return $this->getItemId();
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     *
     * @return self
     */
    protected function setItemId(string $itemId): self
    {
        if ( ! preg_match('/^[0-9]{9,19}$/', $itemId)) {
            throw new UnexpectedValueException(
                sprintf('Invalid item id received. [itemId: %s]', $itemId)
            );
        }

        $this->itemId = $itemId;

        return $this;
    }
}
