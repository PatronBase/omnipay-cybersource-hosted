<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '1.450',
                'currency' => 'OMR',
                'profileId' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
                'accessKey' => 'abc123def456abc789def012abc34567',
                'secretKey' => base64_encode('anextremelylongandveryunguessablesecretkeyforencryptingthings'),
                'cancelUrl' => 'https://www.example.com/cancel',
                'notifyUrl' => 'https://www.example.com/notify',
                'returnUrl' => 'https://www.example.com/return',
                'transactionId' => '123abc',
    
                'description' => 'My sales items',
                'clientIp' => '10.1.2.34',
                'card' => array(
                    'firstName' => 'Test',
                    'lastName' => 'Customer',
                    'billingAddress1' => '1 Some St',
                    'billingAddress2' => 'Suburbia',
                    'billingCity' => 'Tinyton',
                    'billingPostcode' => '123 456',
                    'billingState' => 'Muscat',
                    'billingCountry' => 'OM',
                    'billingPhone' => '123456789',
                    'email' => 'me@example.com',
                ),
                'items' => array(
                    array(
                        'name' => 'My product',
                        'description' => 'A very special product',
                        'quantity' => '1',
                        'price' => '1.450',
                    ),
                ),
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('abc123def456abc789def012abc34567', $data['access_key']);
        $this->assertSame('1.450', $data['amount']);
        $this->assertSame('OMR', $data['currency']);
        $this->assertSame('en', $data['locale']);
        $this->assertSame('ABC12345-A123-4567-8901-2ABCDEF34567', $data['profile_id']);
        $this->assertSame('123abc', $data['reference_number']);
        // signed_date_time is initialized with a date field each time, so no nice way to unit test it
        // $this->assertSame('', $data['signed_date_time']);
        $this->assertSame('sale', $data['transaction_type']);
        $this->assertSame('123abc', $data['transaction_uuid']);
        $this->assertSame('10.1.2.34', $data['customer_ip_address']);
        $this->assertSame('My sales items', $data['merchant_defined_data5']);
        $this->assertSame('https://www.example.com/notify', $data['override_backoffice_post_url']);
        $this->assertSame('https://www.example.com/cancel', $data['override_custom_cancel_page']);
        $this->assertSame('https://www.example.com/return', $data['override_custom_receipt_page']);
        $this->assertSame('Test', $data['bill_to_forename']);
        $this->assertSame('Customer', $data['bill_to_surname']);
        $this->assertSame('1 Some St', $data['bill_to_address_line1']);
        $this->assertSame('Suburbia', $data['bill_to_address_line2']);
        $this->assertSame('Tinyton', $data['bill_to_address_city']);
        $this->assertSame('Muscat', $data['bill_to_address_state']);
        $this->assertSame('123 456', $data['bill_to_address_postal_code']);
        $this->assertSame('OM', $data['bill_to_address_country']);
        $this->assertSame('me@example.com', $data['bill_to_email']);
        $this->assertSame('123456789', $data['bill_to_phone']);
        $this->assertSame(1, $data['line_item_count']);
        $this->assertSame('My product', $data['item_0_name']);
        $this->assertSame('1', $data['item_0_quantity']);
        $this->assertSame('1.450', $data['item_0_unit_price']);
        $this->assertSame('', $data['unsigned_field_names']);
        $this->assertSame(
            'access_key,amount,currency,locale,profile_id,reference_number,signed_date_time,transaction_type'
            .',transaction_uuid,customer_ip_address,merchant_defined_data5,override_backoffice_post_url'
            .',override_custom_cancel_page,override_custom_receipt_page,bill_to_forename,bill_to_surname'
            .',bill_to_address_line1,bill_to_address_line2,bill_to_address_city,bill_to_address_state'
            .',bill_to_address_postal_code,bill_to_address_country,bill_to_email,bill_to_phone,line_item_count'
            .',item_0_name,item_0_quantity,item_0_unit_price,unsigned_field_names,signed_field_names',
            $data['signed_field_names']
        );
    }

    public function testGetDataTestMode()
    {
        $this->request->setTestMode(true);
        $this->assertSame('https://testsecureacceptance.cybersource.com/pay', $this->request->getEndpoint());
        $this->request->setTestMode(false);
        $this->assertSame('https://secureacceptance.cybersource.com/pay', $this->request->getEndpoint());
    }

    public function testGetSecretKey()
    {
        $this->assertSame(
            'YW5leHRyZW1lbHlsb25nYW5kdmVyeXVuZ3Vlc3NhYmxlc2VjcmV0a2V5Zm9yZW5jcnlwdGluZ3RoaW5ncw==',
            $this->request->getSecretKey()
        );
    }

    public function testSetReferenceNumber()
    {
        $this->assertSame('123abc', $this->request->getReferenceNumber());
        $this->request->setReferenceNumber('');
        $this->assertSame('123abc', $this->request->getReferenceNumber());
        $this->request->setReferenceNumber('456xyz');
        $this->assertSame('456xyz', $this->request->getReferenceNumber());
    }

    public function testSetLocale()
    {
        $this->assertSame('en', $this->request->getLocale());
        $this->request->setLocale('');
        $this->assertSame('en', $this->request->getLocale());
        $this->request->setLocale('en-nz');
        $this->assertSame('en-nz', $this->request->getLocale());
    }
}
