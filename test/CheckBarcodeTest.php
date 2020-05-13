<?php

class CheckBarcodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        $this->instance = new ecPay\eInvocie\CheckBarcode(
            $_ENV['SERVER'],
            $_ENV['MERCHANT_ID'],
            $_ENV['HASH_KEY'],
            $_ENV['HASH_IV']
        );
    }

    public function testQuickCheck()
    {
        $this->instance->setBarcode($_ENV['BARCODE'])->sendRequest();

        $response = $this->instance->getResponse();

        $this->assertTrue($response->success());
    }
}
