<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    /** @var PurchaseResponse */
    private $response;

    /**
     * Set up for the tests in this class
     */
    public function setUp()
    {
        $this->response = new PurchaseResponse($this->getMockRequest(), array(
            'access_key' => 'abc123def456abc789def012abc34567',
            'profile_id' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
            'transaction_uuid' => '123abc',
            'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names'
                .',signed_date_time,locale,transaction_type,reference_number,amount,currency',
            'unsigned_field_names' => '',
            'signed_date_time' => '2019-06-18T06:54:40Z',
            'locale' => 'en',
            'transaction_type' => 'sale',
            'reference_number' => '123abc',
            'amount' => '1.450',
            'currency' => 'OMR',
            'signature' => 'tBW94HdDhyHQSMNgvMgLuRSrBB9SiDpzptM1QWUxcrU=',
        ));
    }

    public function testPurchaseSuccess()
    {
        $this->getMockRequest()->shouldReceive('getEndpoint')->once()
            ->andReturn('https://testsecureacceptance.cybersource.com/pay');

        $this->assertFalse($this->response->isSuccessful());
        $this->assertTrue($this->response->isRedirect());
        $this->assertSame('https://testsecureacceptance.cybersource.com/pay', $this->response->getRedirectUrl());
        $this->assertSame('POST', $this->response->getRedirectMethod());
        $this->assertSame(
            array(
                'access_key' => 'abc123def456abc789def012abc34567',
                'profile_id' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
                'transaction_uuid' => '123abc',
                'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names'
                    .',signed_date_time,locale,transaction_type,reference_number,amount,currency',
                'unsigned_field_names' => '',
                'signed_date_time' => '2019-06-18T06:54:40Z',
                'locale' => 'en',
                'transaction_type' => 'sale',
                'reference_number' => '123abc',
                'amount' => '1.450',
                'currency' => 'OMR',
                'signature' => 'tBW94HdDhyHQSMNgvMgLuRSrBB9SiDpzptM1QWUxcrU=',
            ),
            $this->response->getRedirectData()
        );
        $this->assertNull($this->response->getTransactionReference());
        $this->assertNull($this->response->getMessage());
    }
}
