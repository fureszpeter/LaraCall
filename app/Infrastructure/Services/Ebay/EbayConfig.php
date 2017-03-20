<?php
namespace LaraCall\Infrastructure\Services\Ebay;

use Furesz\TypeChecker\TypeChecker;

/**
 * Class EbayConfig.
 */
class EbayConfig
{
    /**
     * @var bool
     */
    private $isSandbox;

    /**
     * @var string
     */
    private $devId;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $certId;

    /**
     * @var null|string
     */
    private $authToken;

    /**
     * @var null|string
     */
    private $sellerUserName;

    /**
     * @var array
     */
    private $credentials = [];

    /**
     * @param bool        $isSandbox
     * @param string      $devId
     * @param string      $appId
     * @param string      $certId
     * @param string|null $authToken
     * @param string|null $sellerUserName
     */
    public function __construct($isSandbox, $devId, $appId, $certId, $authToken = null, $sellerUserName = null)
    {
        TypeChecker::assertBoolean($isSandbox, '$isSandbox');
        TypeChecker::assertString($devId, '$devId');
        TypeChecker::assertString($appId, '$appId');
        TypeChecker::assertString($certId, '$certId');
        if ( ! is_null($authToken)) {
            TypeChecker::assertString($authToken, '$authToken');
        }
        if ( ! is_null($sellerUserName)) {
            TypeChecker::assertString($sellerUserName, '$sellerUserName');
        }

        $this->isSandbox      = $isSandbox;
        $this->devId          = $devId;
        $this->appId          = $appId;
        $this->certId         = $certId;
        $this->authToken      = $authToken;
        $this->sellerUserName = $sellerUserName;

        $this->credentials = [
            'devId'  => $devId,
            'appId'  => $appId,
            'certId' => $certId,
        ];
    }

    /**
     * @return bool
     */
    public function getIsSandbox()
    {
        return $this->isSandbox;
    }

    /**
     * @return string
     */
    public function getDevId()
    {
        return $this->devId;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getCertId()
    {
        return $this->certId;
    }

    /**
     * @return null|string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @return null|string
     */
    public function getSellerUserName()
    {
        return $this->sellerUserName;
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}
