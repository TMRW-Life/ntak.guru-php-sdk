<?php

namespace TmrwLife\NtakGuru;

use OpenSSLAsymmetricKey;
use Throwable;

class Crypt
{
    public static function decrypt(?string $base64String): array|false
    {
        if (!$base64String) {
            return false;
        }

        try {
            $publicKey = self::loadPublicKey();

            $encrypted = base64_decode($base64String);

            openssl_public_decrypt($encrypted, $decrypted, $publicKey);

            return $decrypted;
        } catch (Throwable) {
            return false;
        }
    }

    protected static function loadPublicKey(): OpenSSLAsymmetricKey|false
    {
        $path = dirname(__DIR__).DIRECTORY_SEPARATOR.'openssl'.DIRECTORY_SEPARATOR.'public.key';

        $fp = fopen($path, 'rb');

        $cert = fread($fp, 8192);

        fclose($fp);

        return openssl_get_publickey($cert);
    }
}
