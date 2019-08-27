<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * CyberSource Complete Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     *
     * @throws InvalidResponseException If merchant data or order number is missing, or signature does not match
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        foreach (array('decision', 'signed_field_names', 'signature') as $key) {
            if (empty($data[$key])) {
                throw new InvalidResponseException('Invalid response from payment gateway (no data)');
            }
        }

        $security = new Security();

        $returnSignature = $security->createSignature(
            $data,
            explode(',', $data['signed_field_names']),
            $this->request->getSecretKey()
        );

        if ($returnSignature != $data['signature']) {
            throw new InvalidResponseException('Invalid response from payment gateway (signature mismatch)');
        }
    }

    /**
     * Is the response successful?
     * 
     * Possible values: 'ACCEPT', 'DECLINE', 'REVIEW', 'ERROR', 'CANCEL'
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getKey('decision') === 'ACCEPT';
    }

    /**
     * Get the transaction identifier if available.
     *
     * @return null|string
     */
    public function getTransactionReference()
    {
        return $this->getKey('transaction_id');
    }

    /**
     * Get the authorisation code if available.
     *
     * @return null|string
     */
    public function getAuthCode()
    {
        return $this->getKey('auth_code');
    }

    /**
     * Get the reason code if available.
     *
     * @return null|string
     */
    public function getReasonCode()
    {
        return $this->getKey('reason_code');
    }

    /**
     * Get the merchant response message if available.
     *
     * @return null|string
     */
    public function getMessage()
    {
        return $this->getKey('message');
    }

    /**
     * Get the card number if available.
     *
     * @return null|string
     */
    public function getCardNumber()
    {
        return $this->getKey('req_card_number');
    }

    /**
     * Get the card type if available.
     *
     * @return null|string  3-digit number that maps to CyberSource-specific list of card types
     */
    public function getCardType()
    {
        return $this->getKey('req_card_type');
    }

    /**
     * Get the card expiry if available.
     *
     * @return null|string  Format 'mm-yyyy'
     */
    public function getCardExpiry()
    {
        return $this->getKey('req_card_expiry_date');
    }

    /**
     * Helper method to get a specific response parameter if available.
     *
     * @param string $key The key to look up
     *
     * @return null|mixed
     */
    protected function getKey($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
