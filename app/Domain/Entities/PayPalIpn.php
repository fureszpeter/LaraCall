<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JsonSerializable;
use LaraCall\Domain\PayPal\ValueObjects\PayPalEbayIpn;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedPayPalIpn;
use LaraCall\Domain\ValueObjects\IpnStatus;
use LaraCall\Events\PayPalIpnEntityCreatedEvent;

/**
 * Class PayPalIpn.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrinePayPalIpnRepository")
 * @ORM\Table(uniqueConstraints={@UniqueConstraint(name="uniq_paypal_ipn",
 *                                        columns={"txn_id", "payment_status"})})
 */
class PayPalIpn extends AbstractEntityWithId implements JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $txnId;

    /**
     * @var PayPalIpn
     *
     * @ORM\ManyToOne(targetEntity="PayPalIpn", inversedBy="id", cascade={"persist"})
     */
    protected $parentIpn;

    /**
     * @var PayPalIpn[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PayPalIpn", mappedBy="parentIpn", cascade={"persist"})
     */
    protected $children;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateProcessed;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $processCount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $status;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isValid;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isSandBox;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $salesMessage;

    /**
     * @var Subscription|null
     *
     * @ORM\ManyToOne(targetEntity="Subscription", inversedBy="id", cascade={"persist"})
     */
    protected $subscription;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $paymentStatus;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateOfPayment;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isEbay;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ebayUsername;

    /**
     * @param ValidatedPayPalIpn $saleMessage
     */
    public function __construct(ValidatedPayPalIpn $saleMessage)
    {
        parent::__construct();

        $this->txnId = $saleMessage->getTxnId();

        $this->paymentStatus = $saleMessage->getPaymentStatus();
        $this->dateOfPayment = $saleMessage->getDateOfTransaction();
        $this->isEbay        = $saleMessage->isEbay();
        $this->ebayUsername  = $this->isEbay ? (new PayPalEbayIpn($saleMessage))->getEbayUserId() : null;

        $this->salesMessage = json_encode($saleMessage);
        $this->isSandBox    = $saleMessage->isSandBox();
        $this->status       = (string) new IpnStatus(IpnStatus::STATUS_UNPROCESSED);
        $this->processCount = 0;
        $this->isValid      = $saleMessage->isValid();
        $this->children     = new ArrayCollection();
    }

    /**
     * @return array
     */
    public static function getHeaders(): array
    {
        return [
            'id',
            'txnId',
            'datePayment',
            'dateReceived',
            'dateProcessed',
            'status',
            'processCount',
            'isValid',
            'isSandBox',
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $implode = implode(', ', $this->jsonSerialize());

        return $implode;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->getId(),
            'txnId'         => $this->getTxnId(),
            'datePayment'   => $this->getDateOfPayment()->format(DATE_ISO8601),
            'dateReceived'  => $this->getCreatedAt()->format(DATE_ISO8601),
            'dateProcessed' => $this->getDateProcessed() ? $this->getDateProcessed()->format(DATE_ISO8601) : null,
            'status'        => $this->getStatus(),
            'processCount'  => $this->getProcessCount(),
            'isValid'       => $this->getIsValid(),
            'isSandBox'     => $this->getIsSandbox(),
        ];
    }

    /**
     * @return string
     */
    public function getTxnId(): string
    {
        return $this->txnId;
    }

    /**
     * @return DateTime
     */
    public function getDateOfPayment(): DateTime
    {
        return $this->dateOfPayment;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDateProcessed(): ?DateTimeImmutable
    {
        return $this->dateProcessed
            ? DateTimeImmutable::createFromMutable($this->dateProcessed)
            : null;
    }

    /**
     * @return IpnStatus
     */
    public function getStatus(): IpnStatus
    {
        return new IpnStatus($this->status);
    }

    /**
     * @param IpnStatus $status
     *
     * @return PayPalIpn
     */
    public function setStatus(IpnStatus $status): self
    {
        $this->status = (string) $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getProcessCount(): int
    {
        return $this->processCount;
    }

    /**
     * @return bool
     */
    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return bool
     */
    public function getIsSandbox(): bool
    {
        return $this->isSandBox;
    }

    /**
     * @return PayPalIpn
     */
    public function setProcessedProperties(): self
    {
        $this->processCount++;
        $this->dateProcessed = new DateTimeImmutable();
        $this->setStatus(new IpnStatus(IpnStatus::STATUS_PROCESSED));

        return $this;
    }

    /**
     * @return PayPalIpn
     */
    public function getParentIpn()
    {
        return $this->parentIpn;
    }

    /**
     * @param PayPalIpn $parentIpn
     *
     * @return PayPalIpn
     */
    public function setParentIpn($parentIpn): self
    {
        $this->parentIpn = $parentIpn;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentStatus(): string
    {
        return $this->paymentStatus;
    }

    /**
     * @ORM\PrePersist()
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $parentTxnId = $this->getSalesMessage()->getParentTxnId();

        if ($parentTxnId) {
            /** @var PayPalIpn $parentEntity */
            $parentEntity = $eventArgs->getObjectManager()->getRepository(self::class)->findOneBy([
                'txnId'     => $parentTxnId,
                'parentIpn' => null,
            ]);
            $this
                ->setParentIpn($parentEntity)
                ->setIsEbay($parentEntity->isEbay())
                ->setSubscription($parentEntity->getSubscription())
                ->setEbayUsername($parentEntity->getEbayUsername());
        }
    }

    /**
     * @return ValidatedPayPalIpn
     */
    public function getSalesMessage(): ValidatedPayPalIpn
    {
        return new ValidatedPayPalIpn(json_decode($this->salesMessage, true), $this->getIsValid());
    }

    /**
     * @param bool $isEbay
     *
     * @return PayPalIpn
     */
    public function setIsEbay($isEbay): self
    {
        $this->isEbay = $isEbay;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEbay(): bool
    {
        return $this->isEbay;
    }

    /**
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param null|Subscription $subscription
     *
     * @return PayPalIpn
     */
    public function setSubscription(Subscription $subscription = null): self
    {
        $this->subscription = $subscription;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getEbayUsername(): ?string
    {
        return $this->ebayUsername;
    }

    /**
     * @param string $ebayUsername
     *
     * @return $this
     */
    public function setEbayUsername($ebayUsername)
    {
        $this->ebayUsername = $ebayUsername;

        return $this;
    }

    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $preFlushEventArgs
     */
    public function preFlush(PreFlushEventArgs $preFlushEventArgs)
    {
        if ( ! $this->getSubscription()) {
            return;
        }

        $children = $this->getChildren();

        if (empty($children)) {
            return;
        }

        $entityManager = $preFlushEventArgs->getEntityManager();
        $uow           = $entityManager->getUnitOfWork();

        foreach ($children as $child) {
            if ($child->getSubscription() && $child->getSubscription()->getId() == $this->getSubscription()->getId()) {
                continue;
            }

            $subscription = $this->getSubscription();
            $child->setSubscription($subscription);
            $meta = $entityManager->getClassMetadata(self::class);
            $uow->recomputeSingleEntityChangeSet($meta, $child);
        }
    }

    /**
     * @return ArrayCollection|PayPalIpn[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @ORM\PostPersist()
     */
    public function postPersist()
    {
        event(new PayPalIpnEntityCreatedEvent($this->getId()));
    }
}
