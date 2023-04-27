<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\Log;

class Checkout {
    private $secret;
    private $IV;

    public function __construct($secret, $IV) {
        $this->secret = $secret;
        $this->IV = $IV;
    }

    public function encrypt($requestBody) {
        // $secret = substr(hash('sha256', $this->secret),0,32);
        $secret = hash('sha256', $this->secret);
        $IV = substr(hash('sha256', $this->IV), 0, 16);
        // $secret = $this->secret;
        // $IV = $this->IV;
        // Log::debug($secret);
        // Log::debug($IV);
        $payload = json_encode($requestBody);
        Log::debug($payload);
        $result = openssl_encrypt(
            $payload,
            'AES-256-CBC',
            $secret,
            0,
            $IV
        );
        // Log::debug($result);
        return base64_encode($result);
    }

    public function decrypt($requestBody) {
        // $ciphers             = openssl_get_cipher_methods();
        // print_r($ciphers);
        // $secret = hash('sha256', $this->secret);
        // $IV = substr(hash('sha256', $this->IV), 0, 16);
        // $secret = $this->secret;
        // $IV = $this->IV;
        // $secret = substr(hash('sha256', $this->secret),0,32);
        $secret = hash('sha256', $this->secret);
        $IV = substr(hash('sha256', $this->IV), 0, 16);
        $payload = $requestBody;
        // $payload = json_encode($requestBody);
        // Log::debug(base64_decode($requestBody));
        $result = openssl_decrypt(
            base64_decode($payload),
            'AES-256-CBC',
            $secret,
            0,
            $IV
        );
         Log::debug($result);
        return base64_encode($result);
    }
}
