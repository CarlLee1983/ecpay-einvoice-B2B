<?php

class CheckLoveCodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        $this->instance = new ecPay\eInvocie\CheckLoveCode(
            $_ENV['SERVER'],
            $_ENV['MERCHANT_ID'],
            $_ENV['HASH_KEY'],
            $_ENV['HASH_IV']
        );
    }

    public function testQuickCheck()
    {
        $this->instance->setLoveCode($_ENV['LOVECODE'])->sendRequest();

        $response = $this->instance->getResponse();

        $this->assertTrue($response->success());
    }
}
