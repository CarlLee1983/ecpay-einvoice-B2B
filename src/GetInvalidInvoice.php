<?php

namespace ecPay\eInvoice;

use Exception;

class GetInvalidInvoice extends Content
{
    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '/B2CInvoice/GetInvalid';

    /**
     * Initialize invoice content.
     *
     * @return void
     */
    protected function initContent()
    {
        $this->content['Data'] = [
            'MerchantID' => $this->merchantID,
            'RelateNumber' => '',
            'InvoiceNo' => '',
            'InvoiceDate' => '',
        ];
    }

    /**
     * Setting the invoice no.
     *
     * @param string $invoiceNo
     * @return InvoiceInterface
     */
    public function setInvoiceNo(string $invoiceNo): InvoiceInterface
    {
        if (strlen($invoiceNo) != 10) {
            throw new Exception('The invoice no length should be 10.');
        }

        $this->content['Data']['InvoiceNo'] = $invoiceNo;

        return $this;
    }

    /**
     * Setting invoice data.
     *
     * @param string $date
     * @return InvoiceInterface
     */
    public function setInvoiceDate(string $date): InvoiceInterface
    {
        $format = 'Y-m-d';
        $dateTime = \DateTime::createFromFormat($format, $date);

        if (!($dateTime && $dateTime->format($format) == $date)) {
            throw new Exception('The invoice date format is invalid.');
        }

        $this->content['Data']['InvoiceDate'] = $date;

        return $this;
    }
}
