<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use Symfony\Component\Console\Helper\Table;

class EbayGetBestOffersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:best-offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get ebay best offers';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param EbayApiService $apiService
     *
     * @return mixed
     */
    public function handle(EbayApiService $apiService)
    {
        $bestOffers = $apiService->getBestOffers();

        $table = new Table($this->getOutput());
        $table->setHeaders([
            'id',
            'Expire',
            'User',
            'RegDate',
            'Score',
            'Quantity',
            'Price',
            'Original price',
            'Message',
        ]);

        foreach ($bestOffers->ItemBestOffersArray->ItemBestOffers as $itemBestOffer) {
            foreach ($itemBestOffer->BestOfferArray->BestOffer as $bestOfferType){
                $table->addRow([
                    $bestOfferType->BestOfferID,
                    $bestOfferType->ExpirationTime->format(DATE_ATOM),
                    $bestOfferType->Buyer->UserID,
                    $bestOfferType->Buyer->RegistrationDate->format(DATE_ATOM),
                    $bestOfferType->Buyer->FeedbackScore,
                    $bestOfferType->Quantity,
                    $bestOfferType->Price->value,
                    $itemBestOffer->Item->BuyItNowPrice->value,
                    $bestOfferType->BuyerMessage,
                ]);

            }
        }

        $table->render();
    }
}
