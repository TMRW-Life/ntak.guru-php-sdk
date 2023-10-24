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

            $chunks = explode(',', $base64String);

            $decryptedChunks = array_reduce($chunks, static function ($carry, $base64chunk) use ($publicKey) {
                $chunk = base64_decode($base64chunk);
                openssl_public_decrypt($chunk, $decrypted, $publicKey);

                return [...$carry, $decrypted];
            }, []);

            $originalPayload = implode('', $decryptedChunks);

            return json_decode($originalPayload, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            return false;
        }
    }

    public static function seal(array $data): array
    {
        $ivLength = openssl_cipher_iv_length('AES-256-CBC') ?: 16;

        $iv = openssl_random_pseudo_bytes($ivLength);

        openssl_seal(
            data: json_encode($data),
            sealed_data: $sealed,
            encrypted_keys: $encryptedKeys,
            public_key: [self::loadPublicKey()],
            cipher_algo: 'AES-256-CBC',
            iv: $iv
        );

        return [
            'context' => base64_encode($sealed),
            'envelope' => base64_encode($encryptedKeys[0]),
            'vector' => base64_encode($iv),
        ];
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
