<?php
namespace A2bApiClient\Api\Instances;

use JsonSerializable;
use OutOfBoundsException;

abstract class AbstractInstance implements JsonSerializable
{
    protected $_propertyBag = [];

    /**
     * @param array $_propertyBag
     */
    public function __construct(array $_propertyBag)
    {
        $this->_propertyBag = $_propertyBag;
    }


    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ( ! array_key_exists($name, $this->_propertyBag)) {
            throw new OutOfBoundsException(
                sprintf('Variable not exists. [key: %s]', $name));
        }

        return $this->_propertyBag[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    function __set($name, $value)
    {
        $this->_propertyBag[$name] = $value;
    }

    /**
     * @return array
     */
    public function getBag()
    {
        return $this->_propertyBag;
    }

    public function jsonSerialize()
    {
        return $this->_propertyBag;
    }
}
