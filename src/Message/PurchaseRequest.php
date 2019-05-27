<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * CyberSource Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    /** @var string */
    protected $liveEndpoint = 'https://secureacceptance.cybersource.com/pay';
    /** @var string */
    protected $testEndpoint = 'https://testsecureacceptance.cybersource.com/pay';
    /** @var string  Override this if using inherited class for additional transaction types */
    protected $transactionType = 'sale';

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
     * Optional merchant sale reference number, falls back to using the transaction ID if not set
     *
     * @return string
     */
    public function getReferenceNumber()
    {
        $reference = $this->getParameter('referenceNumber');
        return empty($reference) ? $this->getTransactionId() : $reference;
    }

    /**
     * Set the unique merchant-generated order reference or tracking number for each transaction.
     *
     * @param string $value  Reference to use
     */
    public function setReferenceNumber($value)
    {
        return $this->setParameter('referenceNumber', $value);
    }

    /**
     * Get the locale set for this request, falls back to using 'en' if not set
     *
     * @return string
     */
    public function getLocale()
    {
        $locale = $this->getParameter('locale');
        return empty($locale) ? 'en' : $locale;
    }

    /**
     * Set the locale for this request
     *
     * @param string  $value  ISO formatted string indicating language and country e.g. en-nz
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Get the transaction type
     *
     * Can be one of:
     *  - authorization
     *  - authorization,create_payment_token
     *  - authorization,update_payment_token
     *  - sale
     *  - sale,create_payment_token
     *  - sale,update_payment_token
     *  - create_payment_token
     *  - update_payment_token
     *
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    public function getData()
    {
        $this->validate(
            'profileId',
            'accessKey',
            // the secret key is not supplied in the data, but is required for generating the signature
            'secretKey',
            'amount',
            'currency'
        );

        // mandatory fields
        $data = array(
            'access_key' => $this->getAccessKey(),
            'amount' => $this->getAmount(),
            // uses ISO-4217 codes
            'currency' => $this->getCurrency(),
            'locale' => $this->getLocale(),
            'profile_id' => $this->getProfileId(),
            // no duplicate checking on this (falls back to transaction ID if not set)
            'reference_number' => $this->getReferenceNumber(),
            // ISO 8601 date in UTC
            'signed_date_time' => gmdate("Y-m-d\TH:i:s\Z"),
            'transaction_type' => $this->getTransactionType(),
            // merchant-generated transaction number used for duplicate checking
            'transaction_uuid' => $this->getTransactionId(),
        );

        // optional fields
        $optional_data = array(
            'customer_ip_address' => $this->getClientIp(),
            // merchant defined data 1-4 are stored with tokens, so transaction-specific data from 5 onwards
            'merchant_defined_data5' => $this->getDescription(),
            'override_backoffice_post_url' => $this->getNotifyUrl(),
            'override_custom_cancel_page' => $this->getCancelUrl(),
            // signing this field is actually required if present, despite what the integration docs say
            'override_custom_receipt_page' => $this->getReturnUrl(),
        );

        // billing details
        $card = $this->getCard();
        if ($card) {
            $optional_data += array(
                'bill_to_forename' => $card->getFirstName(),
                'bill_to_surname' => $card->getLastName(),
                'bill_to_address_line1' => $card->getAddress1(),
                'bill_to_address_line2' => $card->getAddress2(),
                'bill_to_address_city' => $card->getCity(),
                //alphanumeric,2 [ISO state code; req for US/CA]
                // @todo should this kind of reformatting (or error) happen in driver, or at merchant end?
                'bill_to_address_state' => $card->getState(),
                // alphanumeric,10 [strict format check for US/CA addresses]
                // @todo should this kind of reformatting (or error) happen in driver, or at merchant end?
                'bill_to_address_postal_code' => $card->getPostcode(),
                'bill_to_address_country' => $card->getCountry(),
                'bill_to_email' => $card->getEmail(),
                'bill_to_phone' => $card->getPhone(),
            );
        }

        // item details
        $items = $this->getItems();
        if ($items) {
            // having any item details forces line_item_count to be required
            $optional_data += array(
                'line_item_count' => count($items),
            );
            foreach ($items as $n => $item) {
                $optional_data += array(
                    "item_{$n}_name" => $item->getName(),
                    "item_{$n}_quantity" => $item->getQuantity(),
                    "item_{$n}_unit_price" => $this->formatCurrency($item->getPrice()),
                );
                // @todo if we want to add additional fields, need to create CyberSourceItem and CyberSourceItemBag
                // if ($item instanceof CyberSourceItem) {
                //     "item_{$n}_code" => $item->getCode(),
                //     "item_{$n}_sku" => $item->getSku(),
                //     "item_{$n}_tax_amount" => $this->formatCurrency($item->getTax()),
                // }
            }
        }

        // omit any optional parameters that aren't set
        $optional_data = array_filter($optional_data);
        // merge data
        $data += $optional_data;

        // rather than working out peculiar loopholes in the integration documentation, just sign everything
        $data['unsigned_field_names'] = '';
        $data['signed_field_names'] = implode(',', array_keys($data)).',signed_field_names';

        return $data;
    }

    public function sendData($data)
    {
        $security = new Security();
        $data['signature'] = $security->createSignature(
            $data,
            explode(',', $data['signed_field_names']),
            $this->getSecretKey()
        );
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
