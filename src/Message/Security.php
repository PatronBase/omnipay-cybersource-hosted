<?php

namespace Omnipay\CyberSource\Message;

/**
 * Security
 *
 * This class provides a common signing function.
 * While this code could be called statically, it is left as a regular class in order to faciliate unit testing.
 */
class Security
{
    /**
     * Create signature hash used to verify messages
     *
     * @param mixed[]  $data    Full set of data
     * @param string[] $fields  Array of keys to filter
     * @param string   $key     The key used to encrypt the data
     *
     * @return string  Generated signature
     */
    public function createSignature($data, $fields, $key)
    {
        $signable = array();
        foreach ($fields as $field) {
            $signable[] = $field.'='.$data[$field];
        }
        $message = implode(',', $signable);
        return base64_encode(hash_hmac('sha256', $message, $key, true));
    }
}
