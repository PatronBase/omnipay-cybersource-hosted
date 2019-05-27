<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Tests\TestCase;
use Mockery as m;

class SecurityTest extends TestCase
{
    protected $security;
    protected $mockSecurity;
    protected $key;

    public function setUp()
    {
        $this->security = new Security;
        $this->mockSecurity = m::mock('\Omnipay\CyberSource\Message\Security');
        $this->key = base64_encode('anextremelylongandveryunguessablesecretkeyforencryptingthings');
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Test creating a signature with fields typical to a slim purchase request
     */
    public function testCreateSignature()
    {
        $data = array(
            'access_key' => 'abc123def456abc789def012abc34567',
            'amount' => '1.450',
            'currency' => 'OMR',
            'locale' => 'en',
            'profile_id' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
            'reference_number' => '123abc',
            'signed_date_time' => '2019-06-18T06:54:40Z',
            'transaction_type' => 'sale',
            'transaction_uuid' => '123abc',
            'unsigned_field_names' => '',
            'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names'
                .',signed_date_time,locale,transaction_type,reference_number,amount,currency',
            'unsigned_field' => 'Something that is not signed or used in any way',
        );
        $fields = array(
            'access_key',
            'profile_id',
            'transaction_uuid',
            'signed_field_names',
            'unsigned_field_names',
            'signed_date_time',
            'locale',
            'transaction_type',
            'reference_number',
            'amount',
            'currency',
        );
        $signature = $this->security->createSignature($data, $fields, $this->key);
        $this->assertSame('tBW94HdDhyHQSMNgvMgLuRSrBB9SiDpzptM1QWUxcrU=', $signature);
    }

    /**
     * Test creating a signature with fields typical to a slim complete purchase response
     */
    public function testCreateReturnSignature()
    {
        $data = array(
            'req_currency' => 'OMR',
            'decision' => 'CANCEL',
            'message' => 'The consumer cancelled the transaction',
            'req_transaction_uuid' => '123456',
            'req_transaction_type' => 'sale',
            'unsigned_field' => 'Something that is not signed or used in any way',
        );
        $fields = array('req_currency', 'decision', 'message', 'req_transaction_uuid', 'req_transaction_type');
        $key = base64_encode('anextremelylongandveryunguessablesecretkeyforencryptingthings');
        $signature = $this->security->createSignature($data, $fields, $key);
        $this->assertSame('4nghD9kZUIcgVp0gmzihArq5Gk5+GwQb624uR0MSoKY=', $signature);
    }
}
