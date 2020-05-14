<?php

class InvoiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        $this->instance = new ecPay\eInvoice\Invoice(
            $_ENV['SERVER'],
            $_ENV['MERCHANT_ID'],
            $_ENV['HASH_KEY'],
            $_ENV['HASH_IV']
        );
    }

    public function testQuickCreate()
    {
        $this->instance->setRelateNumber('YEP' . date('YmdHis'))
            ->setCustomerEmail('cylee@chyp.com.tw')
            ->setItems([
                [
                    'name' => '商品範例',
                    'quantity' => 1,
                    'unit' => '個',
                    'price' => 100,
                    'totalPrice' => 100,
                ],
            ])
            ->setSalesAmount(100)
            ->sendRequest();

        $response = $this->instance->getResponse();

        $this->assertTrue($response->success());
    }
}
