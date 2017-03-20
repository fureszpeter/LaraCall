<?php
namespace LaraCall\Domain\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Furesz\TypeChecker\TypeChecker;
use LaraCall\Domain\Entities\EbayUser;

class EbayUserCollection extends ArrayCollection
{
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            TypeChecker::assertInstanceOf($element, EbayUser::class);
        }

        parent::__construct($elements);
    }

    /**
     * @param EbayUser $value
     *
     * @return bool
     */
    public function add($value)
    {
        TypeChecker::assertInstanceOf($value, EbayUser::class);

        return parent::add($value);
    }

    /**
     * @param int|string $key
     * @param EbayUser   $value
     */
    public function set($key, $value)
    {
        TypeChecker::assertInstanceOf($value, EbayUser::class);

        parent::set($key, $value);
    }

    /**
     * @param string $token
     *
     * @return EbayUser|null
     */
    public function findByToken(string $token): ?EbayUser
    {
        return $this->filter(function (EbayUser $ebayUserEntity) use ($token) {
            return $ebayUserEntity->getEbayUserTokenId() == $token;
        })->first();
    }

    /**
     * @param string $username
     *
     * @return EbayUser|null
     */
    public function findByUsername(string $username): ?EbayUser
    {
        return $this->filter(function (EbayUser $ebayUserEntity) use ($username) {
            return $ebayUserEntity->getEbayUserId() == $username;
        })->first();
    }
}
