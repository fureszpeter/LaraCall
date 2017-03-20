<?php
namespace LaraCall\Domain\Registration\Services;

use DateTime;
use LaraCall\Domain\Entities\EbayUser;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Repositories\EbayUserRepository;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;

class EbayService
{
    /**
     * @var EbayApiService
     */
    private $apiService;

    /**
     * @var EbayUserRepository
     */
    private $ebayUserRepository;

    /**
     * @param EbayApiService     $apiService
     * @param EbayUserRepository $ebayUserRepository
     */
    public function __construct(EbayApiService $apiService, EbayUserRepository $ebayUserRepository)
    {
        $this->apiService         = $apiService;
        $this->ebayUserRepository = $ebayUserRepository;
    }

    /**
     * @param string $userName
     * @param Subscription $subscription
     *
     * @return EbayUser
     */
    public function getOrSaveEbayUser(string $userName, Subscription $subscription): EbayUser
    {
        $ebayUser = $this->ebayUserRepository->findOneBy(['ebayUserId' => $userName]);

        if ( ! $ebayUser) {
            $token    = $this->apiService->getUser($userName)->User->EIASToken;
            $ebayUser = new EbayUser(
                $token,
                $userName,
                $subscription->getUser()->getEmail(),
                new DateTime()
            );
            $ebayUser->setSubscription($subscription);
            $ebayUser = $this->ebayUserRepository->save($ebayUser);
        }

        return $ebayUser;
    }
}
