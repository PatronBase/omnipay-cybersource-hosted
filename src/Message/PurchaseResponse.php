<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * CyberSource Purchase Response
 */
class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getRequest()->getEndpoint();
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
