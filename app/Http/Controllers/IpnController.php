<?php

namespace LaraCall\Http\Controllers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use LaraCall\Domain\Entities\IpnQueue;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Domain\Repositories\IpnQueueRepository;

/**
 * Class IpnController.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class IpnController extends Controller
{
    /** @var Dispatcher */
    private $dispatcher;

    /** @var PayPalIpnValidator */
    private $payPalIpnValidator;

    /** @var IpnQueueRepository */
    private $ipnQueueRepository;

    /**
     * @param Dispatcher         $dispatcher
     * @param PayPalIpnValidator $payPalIpnValidator
     * @param IpnQueueRepository $ipnQueueRepository
     */
    public function __construct(
        Dispatcher $dispatcher,
        PayPalIpnValidator $payPalIpnValidator,
        IpnQueueRepository $ipnQueueRepository

    ) {
        $this->dispatcher         = $dispatcher;
        $this->payPalIpnValidator = $payPalIpnValidator;
        $this->ipnQueueRepository = $ipnQueueRepository;
    }

    /**
     * @param Request $request
     */
    public function payPalIpn(Request $request)
    {
        $rawData  = $request->request->all();

        $ipnQueue = new IpnQueue($rawData, $request->server());

        $this->ipnQueueRepository->save($ipnQueue);
    }
}
