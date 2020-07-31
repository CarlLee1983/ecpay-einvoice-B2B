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
        $this->instance->setRelateNumber('YEP' . date('YmdHis') . rand(10, 99))
            ->setCarrierType('1')
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

    public function testCarrier()
    {
        $this->instance->setRelateNumber('YEP' . date('YmdHis') . rand(10, 99))
            ->setCarrierType('3')
            ->setCarrierNum('/YC+RROR')
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

    public function testIdentifier()
    {
        $this->instance->setRelateNumber('YEP' . date('YmdHis') . rand(10, 99))
            ->setCustomerIdentifier('28465676')
            ->setCustomerName('中華國際黃頁股份有限公司')
            ->setCustomerAddr('台中市北區進化路322號')
            ->setCustomerEmail('cylee@chyp.com.tw')
            ->setPrintMark('1')
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
