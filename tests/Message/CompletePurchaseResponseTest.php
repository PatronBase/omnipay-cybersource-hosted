<?php

namespace Omnipay\CyberSource\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    /** @var CompletePurchaseResponse */
    private $response;

    /** @var string  Use the same secret key for testing signatures */
    private $testSecretKey;

    public function setUp()
    {
        $this->testSecretKey = base64_encode('anextremelylongandveryunguessablesecretkeyforencryptingthings');
    }

    public function testCompletePurchaseSuccess()
    {
        $this->getMockRequest()->shouldReceive('getSecretKey')->once()->andReturn($this->testSecretKey);

        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'utf8' => '✓',
                'auth_cv_result' => 'M',
                'score_device_fingerprint_images_enabled' => 'true',
                'req_locale' => 'en',
                'score_score_result' => '84',
                'decision_case_priority' => '3',
                'req_card_type_selection_indicator' => '1',
                'auth_trans_ref_no' => '1234567890123456789012',
                'req_bill_to_surname' => 'Customer',
                'req_card_expiry_date' => '12-2020',
                'score_rflag' => 'DSCORE',
                'score_card_issuer' => 'RIVER VALLEY CREDIT UNION',
                'score_rcode' => '1',
                'req_bill_to_phone' => '123456789',
                'auth_amount' => '1.450',
                'auth_response' => '00',
                'bill_trans_ref_no' => '1234567890123456789012',
                'req_payment_method' => 'card',
                'score_device_fingerprint_true_ipaddress_city' => 'muscat',
                'auth_time' => '2019-06-25T083309Z',
                'decision_early_return_code' => '9999999',
                'transaction_id' => '1234567890123456789012',
                'req_card_type' => '001',
                'score_device_fingerprint_javascript_enabled' => 'true',
                'score_device_fingerprint_screen_resolution' => '1920x1080',
                'score_velocity_info' => 'VELI-FP^VELI-TIP^VELL-TIP^VELS-FP^VELS-TIP',
                'auth_avs_code' => 'Y',
                'auth_code' => '831000',
                'score_address_info' => 'MM-BIN^UNV-ADDR',
                'score_factors' => 'B^P^Q',
                'score_model_used' => 'default_cemea',
                'req_bill_to_address_country' => 'OM',
                'auth_cv_result_raw' => 'M',
                'decision_rmsg' => 'Service processed successfully',
                'req_profile_id' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
                'score_device_fingerprint_cookies_enabled' => 'true',
                'decision_rcode' => '1',
                'score_rmsg' => 'Score exceeds threshold. Score = 84',
                'score_device_fingerprint_hash' => '70866bbdadd84bee156df8f9cfc677d2',
                'score_device_fingerprint_browser_language' => 'en-US,en;q=0.9',
                'decision_rflag' => 'SOK',
                'signed_date_time' => '2019-06-25T08:33:10Z',
                'req_bill_to_address_line1' => '1 Some St',
                'req_card_number' => '411111xxxxxx1111',
                'score_device_fingerprint_true_ipaddress' => '10.1.2.34',
                'signature' => '5WuJI1Jl/A5mjznpmU8vqXnaMdZ0BTIYotLiQTKxKHg=',
                'score_card_scheme' => 'VISA CREDIT',
                'score_device_fingerprint_true_ipaddress_country' => 'OM',
                'score_bin_country' => 'US',
                'req_bill_to_address_city' => 'Tinyton',
                'auth_cavv_result' => '2',
                'score_reason_code' => '100',
                'reason_code' => '100',
                'req_bill_to_forename' => 'Test',
                'score_identity_info' => 'MORPH-P',
                'request_token' => 'Abc//dEFGHI0Jkl1234MNOpqrstUVwxyZ567Abcdefg12HIJKlmnop3456QRSTuVWXYZ7890ABCDEF123GH'
                    .'IJ456KLMnop7QrsTuvWXYZ890',
                'req_device_fingerprint_id' => 'abcdef1234567890123abc456789def0ABC123DE-F456-7890-12AB-34CDE567F890',
                'auth_cavv_result_raw' => '2',
                'score_card_account_type' => 'Visa Gold',
                'req_amount' => '1.450',
                'req_bill_to_email' => 'me@example.com',
                'auth_avs_code_raw' => 'Y',
                'decision_velocity_info' => 'GVEL-R5004^GVEL-R5029^GVEL-R5030',
                'req_currency' => 'OMR',
                'score_device_fingerprint_smart_id_confidence_level' => '100.00',
                'decision' => 'ACCEPT',
                'decision_return_code' => '1320000',
                'message' => 'Request was processed successfully.',
                'signed_field_names' => 'transaction_id,decision,req_access_key,req_profile_id,req_transaction_uuid'
                    .',req_transaction_type,req_reference_number,req_amount,req_currency,req_locale,req_payment_method'
                    .',req_bill_to_forename,req_bill_to_surname,req_bill_to_email,req_bill_to_phone'
                    .',req_bill_to_address_line1,req_bill_to_address_city,req_bill_to_address_country,req_card_number'
                    .',req_card_type,req_card_type_selection_indicator,req_card_expiry_date,req_device_fingerprint_id'
                    .',message,reason_code,auth_avs_code,auth_avs_code_raw,auth_response,auth_amount,auth_code'
                    .',auth_cavv_result,auth_cavv_result_raw,auth_cv_result,auth_cv_result_raw,auth_trans_ref_no'
                    .',auth_time,request_token,bill_trans_ref_no,score_device_fingerprint_cookies_enabled'
                    .',score_device_fingerprint_flash_enabled,score_device_fingerprint_hash'
                    .',score_device_fingerprint_images_enabled,score_device_fingerprint_javascript_enabled'
                    .',score_device_fingerprint_true_ipaddress,score_device_fingerprint_true_ipaddress_city'
                    .',score_device_fingerprint_true_ipaddress_country,score_device_fingerprint_screen_resolution'
                    .',score_device_fingerprint_smart_id,score_device_fingerprint_smart_id_confidence_level'
                    .',score_device_fingerprint_browser_language,score_factors,score_rcode,score_time_local'
                    .',score_model_used,score_return_code,score_host_severity,score_score_result,score_reason_code'
                    .',score_rflag,score_rmsg,score_address_info,score_card_account_type,score_card_issuer'
                    .',score_card_scheme,score_identity_info,score_velocity_info,decision_early_return_code'
                    .',decision_early_reason_code,decision_reason_code,decision_rmsg,decision_rcode'
                    .',decision_case_priority,decision_return_code,decision_early_rcode,decision_rflag'
                    .',decision_velocity_info,score_bin_country,signed_field_names,signed_date_time',
                'req_transaction_uuid' => '123abc',
                'decision_reason_code' => '100',
                'score_device_fingerprint_smart_id' => '0ea0c849adff4968999c05cfe9ae7317',
                'score_time_local' => '12:33:09',
                'score_return_code' => '1072000',
                'score_host_severity' => '1',
                'req_transaction_type' => 'sale',
                'req_access_key' => 'abc123def456abc789def012abc34567',
                'decision_early_reason_code' => '100',
                'req_reference_number' => '123abc',
                'score_device_fingerprint_flash_enabled' => 'false',
                'decision_early_rcode' => '1',
            )
        );

        $this->assertTrue($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertSame('1234567890123456789012', $this->response->getTransactionReference());
        $this->assertSame('123abc', $this->response->getTransactionId());
        $this->assertSame('831000', $this->response->getAuthCode());
        $this->assertSame('100', $this->response->getReasonCode());
        $this->assertSame('Request was processed successfully.', $this->response->getMessage());
        $this->assertSame('411111xxxxxx1111', $this->response->getCardNumber());
        $this->assertSame('001', $this->response->getCardType());
        $this->assertSame('12-2020', $this->response->getCardExpiry());
        $data = $this->response->getData();
        $this->assertSame('ACCEPT', $data['decision']);
    }

    public function testCompletePurchaseFailure()
    {
        $this->getMockRequest()->shouldReceive('getSecretKey')->once()->andReturn($this->testSecretKey);

        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'utf8' => '✓',
                'req_card_number' => '411111xxxxxx1111',
                'req_locale' => 'en',
                'signature' => 'wkpxIayM7BjIZK6PXX6nqe0VVTQo7vwjPNJqW/iOhmo=',
                'req_card_type_selection_indicator' => '1',
                'req_bill_to_surname' => 'Customer',
                'req_bill_to_address_city' => 'Tinyton',
                'req_card_expiry_date' => '12-2020',
                'req_bill_to_phone' => '123456789',
                'reason_code' => '101',
                'req_bill_to_forename' => 'Test',
                'req_payment_method' => 'card',
                'request_token' => 'Abcdefg12HIJKlmnop3456QRSTuVWXYZ7890ABCDEF123GHIJ456KLMnop7QrsTuvWXYZ890',
                'req_device_fingerprint_id' => 'abcdef1234567890123abc456789def0ABC123DE-F456-7890-12AB-34CDE567F890',
                'decision_early_return_code' => '9999999',
                'req_amount' => '1.450',
                'req_bill_to_email' => 'me@example.com',
                'decision_velocity_info' => 'GVEL-R5030',
                'transaction_id' => '1234567890123456789012',
                'req_currency' => 'OMR',
                'req_card_type' => '001',
                'decision' => 'DECLINE',
                'message' => 'The request data did not pass the required fields check for this application: '
                    .'[bill_country]',
                'signed_field_names' => 'transaction_id,decision,req_access_key,req_profile_id,req_transaction_uuid'
                    .',req_transaction_type,req_reference_number,req_amount,req_currency,req_locale,req_payment_method'
                    .',req_bill_to_forename,req_bill_to_surname,req_bill_to_email,req_bill_to_phone'
                    .',req_bill_to_address_line1,req_bill_to_address_city,req_card_number,req_card_type'
                    .',req_card_type_selection_indicator,req_card_expiry_date,req_device_fingerprint_id,message'
                    .',reason_code,request_token,decision_early_return_code,decision_early_reason_code'
                    .',decision_early_rcode,decision_velocity_info,signed_field_names,signed_date_time',
                'req_transaction_uuid' => '123abc',
                'req_transaction_type' => 'sale',
                'req_access_key' => 'abc123def456abc789def012abc34567',
                'decision_early_reason_code' => '100',
                'req_profile_id' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
                'req_reference_number' => '123abc',
                'decision_early_rcode' => '1',
                'signed_date_time' => '2019-06-25T08:16:52Z',
                'req_bill_to_address_line1' => '1 Some St',
            )
        );

        $this->assertFalse($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertSame('1234567890123456789012', $this->response->getTransactionReference());
        $this->assertNull($this->response->getAuthCode());
        $this->assertSame('101', $this->response->getReasonCode());
        $this->assertSame(
            'The request data did not pass the required fields check for this application: [bill_country]',
            $this->response->getMessage()
        );
        $this->assertSame('411111xxxxxx1111', $this->response->getCardNumber());
        $this->assertSame('001', $this->response->getCardType());
        $this->assertSame('12-2020', $this->response->getCardExpiry());
        $data = $this->response->getData();
        $this->assertSame('DECLINE', $data['decision']);
    }

    public function testCompletePurchaseError()
    {
        $this->getMockRequest()->shouldReceive('getSecretKey')->once()->andReturn($this->testSecretKey);

        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'utf8' => '✓',
                'req_locale' => 'en',
                'signature' => '9Fq2jQWBuaiYufoZF+qjFdl5YqHut4dX6L8DOmMqMgk=',
                'req_card_type_selection_indicator' => '1',
                'req_payment_method' => 'card',
                'req_amount' => '1.450',
                'req_currency' => 'OMR',
                'decision' => 'ERROR',
                'message' => 'Issuing bank has indicated a fraud alert',
                'signed_field_names' => 'req_currency,decision,req_locale,req_card_type_selection_indicator,message'
                    .',req_transaction_uuid,req_transaction_type,req_payment_method,req_access_key,req_profile_id'
                    .',req_reference_number,req_amount,signed_field_names,signed_date_time',
                'req_transaction_uuid' => '123abc',
                'req_transaction_type' => 'sale',
                'req_access_key' => 'abc123def456abc789def012abc34567',
                'req_profile_id' => 'ABC12345-A123-4567-8901-2ABCDEF34567',
                'req_reference_number' => '123abc',
                'signed_date_time' => '2019-06-25T07:41:32Z',
            )
        );

        $this->assertFalse($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertNull($this->response->getTransactionReference());
        $this->assertNull($this->response->getAuthCode());
        $this->assertNull($this->response->getReasonCode());
        $this->assertSame('Issuing bank has indicated a fraud alert', $this->response->getMessage());
        $this->assertNull($this->response->getCardNumber());
        $this->assertNull($this->response->getCardType());
        $this->assertNull($this->response->getCardExpiry());
        $data = $this->response->getData();
        $this->assertSame('ERROR', $data['decision']);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCompletePurchaseInvalidNoParameters()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidResponseException');
        $this->expectExceptionMessage('Invalid response from payment gateway (no data)');
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array()
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCompletePurchaseInvalidNoDecision()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidResponseException');
        $this->expectExceptionMessage('Invalid response from payment gateway (no data)');
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'signed_field_names' => 'decision',
                'signature' => 'abc',
            )
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCompletePurchaseInvalidNoSignatureDefinition()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidResponseException');
        $this->expectExceptionMessage('Invalid response from payment gateway (no data)');
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'decision' => 'ERROR',
                'signature' => 'abc',
            )
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCompletePurchaseInvalidNoSignature()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidResponseException');
        $this->expectExceptionMessage('Invalid response from payment gateway (no data)');
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'decision' => 'ERROR',
                'signed_field_names' => 'decision',
            )
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCompletePurchaseInvalidEmptySignature()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidResponseException');
        $this->expectExceptionMessage('Invalid response from payment gateway (no data)');
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'decision' => 'ERROR',
                'signed_field_names' => 'decision',
                'signature' => '',
            )
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCompletePurchaseInvalidSignature()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidResponseException');
        $this->expectExceptionMessage('Invalid response from payment gateway (signature mismatch)');

        $this->getMockRequest()->shouldReceive('getSecretKey')->once()->andReturn($this->testSecretKey);

        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'decision' => 'ERROR',
                'signed_field_names' => 'decision',
                'signature' => 'aClearlyWrongSignature=',
            )
        );
    }
}
