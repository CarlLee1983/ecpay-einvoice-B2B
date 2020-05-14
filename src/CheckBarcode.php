<?php

namespace ecPay\eInvocie;

use Exception;

class CheckBarcode extends Content
{
    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '/B2CInvoice/CheckBarcode';

    /**
     * Initialize invoice content.
     *
     * @return void
     */
    protected function initContent()
    {
        $this->content['Data'] = [
            'MerchantID' => $this->merchantID,
            'BarCode' => '',
        ];
    }

    /**
     * Setting barcode.
     *
     * @param string $code
     * @return @return InvoiceInterface
     */
    public function setBarcode(string $code): InvoiceInterface
    {
        if (strlen($code) != 8) {
            throw new Exception('Phone barcode length must be 8 characters.');
        }

        $this->content['Data']['BarCode'] = strtoupper($code);

        return $this;
    }

    /**
     * Validation content.
     *
     * @return void
     */
    public function validation()
    {
        $this->validatorBaseParam();

        if (empty($this->content['Data']['BarCode'])) {
            throw new Exception('Phone barcode is empty.');
        }
    }
}
