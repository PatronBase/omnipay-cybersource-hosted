<?php

namespace Omnipay\CyberSource;

use Omnipay\Common\AbstractGateway;
use Omnipay\CyberSource\Message\CompletePurchaseRequest;
use Omnipay\CyberSource\Message\PurchaseRequest;

/**
 * CyberSource Secure Acceptance Hosted Checkout Gateway
 *
 * @link https://www.cybersource.com/developers/getting_started/integration_methods/secure_acceptance_wm/
 */
class HostedGateway extends AbstractGateway
{
    public function getName()
    {
        return 'CyberSource Hosted';
    }

    public function getDefaultParameters()
    {
        return array(
            'profileId' => '',
            'accessKey' => '',
            'secretKey' => '',
            'testMode' => false,
        );
    }

    /**
     * Get the profile ID for the merchant account
     *
     * @return string
     */
    public function getProfileId()
    {
        return $this->getParameter('profileId');
    }

    /**
     * Set the profile ID for the merchant account
     *
     * @param string $value  ASCII Alphanumeric + punctuation string, maximum 36 characters
     *
     * @return AbstractRequest
     */
    public function setProfileId($value)
    {
        return $this->setParameter('profileId', $value);
    }

    /**
     * Get the secret key for the merchant account
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the secret key for the merchant account
     *
     * @param string $value  Alphanumeric string, maximum 32 characters
     *
     * @return AbstractRequest
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * Get the access key for the merchant account
     *
     * @return string
     */
    public function getAccessKey()
    {
        return $this->getParameter('accessKey');
    }

    /**
     * Set the access key for the merchant account
     *
     * @param string $value  Alphanumeric string, maximum 32 characters
     *
     * @return AbstractRequest
     */
    public function setAccessKey($value)
    {
        return $this->setParameter('accessKey', $value);
    }

    /**
     * Redirect the customer to CyberSource to make a purchase
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSource\Message\PurchaseRequest', $parameters);
    }

    /**
     * Complete a purchase process
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSource\Message\CompletePurchaseRequest', $parameters);
    }
}
