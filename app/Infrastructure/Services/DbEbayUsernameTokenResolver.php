<?php
namespace LaraCall\Infrastructure\Services;

use LaraCall\Domain\Repositories\EbayUserRepository;
use LaraCall\Domain\Services\EbayUsernameTokenResolver;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use OutOfBoundsException;
use RuntimeException;

class DbEbayUsernameTokenResolver implements EbayUsernameTokenResolver
{
    /**
     * @var EbayUserRepository
     */
    private $ebayUserRepository;

    /**
     * @var EbayApiService
     */
    private $ebayApiService;

    /**
     * @param EbayUserRepository $ebayUserRepository
     * @param EbayApiService     $ebayApiService
     */
    public function __construct(EbayUserRepository $ebayUserRepository, EbayApiService $ebayApiService)
    {
        $this->ebayUserRepository = $ebayUserRepository;
        $this->ebayApiService = $ebayApiService;
    }

    /**
     * @param string $username
     *
     * @return string
     *
     * @throws OutOfBoundsException If no user found.
     */
    public function resolveUsername2Token(string $username): string
    {
        $ebayUserEntity = $this->ebayUserRepository->findOneBy(
            [
                'ebayUserId' => $username
            ]
        );

        if ($ebayUserEntity) {
            return $ebayUserEntity->getEbayUserTokenId();
        }

        try{
            return $this->ebayApiService->getUser($username)->User->EIASToken;
        }catch (RuntimeException $exception) {
            throw new OutOfBoundsException(sprintf('Ebay user not found. [ebay id: %s]', $username));
        }
    }

    public function resolveToken2Username(string $token): string
    {
        return $this->ebayUserRepository->get($token)->getEbayUserId();
    }
}
