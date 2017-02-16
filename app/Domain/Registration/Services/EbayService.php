<?php
namespace LaraCall\Domain\Registration\Services;

use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use OutOfBoundsException;

class EbayService
{
    /**
     * @var EbayApiService
     */
    private $apiService;

    /**
     * @param EbayApiService $apiService
     */
    public function __construct(EbayApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @param string $username
     *
     * @throws OutOfBoundsException If user not found.
     *
     * @return array
     */
    public function getEbayUserByUsername(string $username) : array
    {

    }
}
