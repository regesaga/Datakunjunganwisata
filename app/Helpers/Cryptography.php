<?php

namespace App\Helpers;

/**
 * Helpers for return format of SPK Number
 */
class Cryptography
{
    private static $key = 'KUNINGAN1234567890';
    private static $cipher = "AES-128-CBC";

    public static function encryptString(string $string)
    {
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $ciphertext_raw = openssl_encrypt($string, self::$cipher, self::$key,  OPENSSL_RAW_DATA, $iv);
        return base64_encode($ciphertext_raw);
    }

    public static function decryptString(string $encrypt_code)
    {
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $ciphertext = base64_decode($encrypt_code);
        return openssl_decrypt($ciphertext, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv);
    }

    public static function decryptJson(string $encrypt_code)
    {
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $ciphertext = base64_decode($encrypt_code);
        return json_decode(openssl_decrypt($ciphertext, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv));
    }
}
