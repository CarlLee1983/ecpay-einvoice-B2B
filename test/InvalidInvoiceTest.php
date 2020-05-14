<?php

class InvalidInvoiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        $this->instance = new ecPay\eInvoice\InvalidInvoice(
            $_ENV['SERVER'],
            $_ENV['MERCHANT_ID'],
            $_ENV['HASH_KEY'],
            $_ENV['HASH_IV']
        );
    }

    public function testQuickCheck()
    {
        $relateNumber = 'YEP' . date('YmdHis');
        $invoice = new ecPay\eInvoice\Invoice(
            $_ENV['SERVER'],
            $_ENV['MERCHANT_ID'],
            $_ENV['HASH_KEY'],
            $_ENV['HASH_IV']
        );
        $invoice->setRelateNumber($relateNumber)
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

        $response = $invoice->getResponse();

        if ($response->success()) {
            $data = $response->getData();

            $this->instance->setRelateNumber($relateNumber)
                ->setInvoiceNo($data['InvoiceNo'])
                ->setInvoiceDate(date('Y-m-d', strtotime($data['InvoiceDate'])))
                ->setReason('Cancel Order.')
                ->sendRequest();

            $response = $this->instance->getResponse();

            $this->assertTrue($response->success());
        }
    }
}
