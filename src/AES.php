<?php

namespace ecPay\eInvocie;

/**
 * AES encryption and decryption.
 */
trait AES
{
    /**
     * To AES encryption by 128 bit, chiper mode is CBC, padding mode is PKCS7.
     *
     * @param string $data
     * @return string
     */
    protected function encrypt(string $data): string
    {
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $blockSize - (strlen($data) % $blockSize);
        $code = mcrypt_encrypt(
            MCRYPT_RIJNDAEL_128,
            $this->hashKey,
            $data . str_repeat(chr($pad), $pad),
            MCRYPT_MODE_CBC,
            $this->hashIV
        );

        return base64_encode($code);
    }

    /**
     * Decrypt the content.
     *
     * @param string $data
     * @return string
     */
    public function decrypt(string $data): string
    {
        $data = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $this->hashKey,
            base64_decode($data),
            MCRYPT_MODE_CBC,
            $this->hashIV
        );
        $pad = ord($data[strlen($data) - 1]);

        return urldecode(substr($data, 0, -$pad));
    }
}
