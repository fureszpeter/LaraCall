<?php

namespace LaraCall\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use LaraCall\Domain\Entities\PayPalIpn as PayPalIpnEntity;
use LaraCall\Domain\Repositories\PayPalIpnRepository;

/**
 * Class IpnController.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class IpnController extends Controller
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var PayPalIpnValidator
     */
    private $payPalIpnValidator;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var PayPalIpnRepository
     */
    private $ipnSalesMessageRepository;

    /**
     * @param Dispatcher          $dispatcher
     * @param PayPalIpnValidator  $payPalIpnValidator
     * @param EntityManager       $em
     * @param PayPalIpnRepository $ipnSalesMessageRepository
     */
    public function __construct(
        Dispatcher $dispatcher,
        PayPalIpnValidator $payPalIpnValidator,
        EntityManager $em,
        PayPalIpnRepository $ipnSalesMessageRepository

    ) {
        $this->dispatcher                = $dispatcher;
        $this->payPalIpnValidator        = $payPalIpnValidator;
        $this->em                        = $em;
        $this->ipnSalesMessageRepository = $ipnSalesMessageRepository;
    }

    /**
     * @param Request $request
     */
    public function payPalIpn(Request $request)
    {
        $ipnSalesMessage = $this->payPalIpnValidator->validateIpn(new PayPalIpn($request->request->all()));

        $entity = new PayPalIpnEntity($ipnSalesMessage);
        $this->em->persist($entity);
        $this->em->flush();
    }
}
