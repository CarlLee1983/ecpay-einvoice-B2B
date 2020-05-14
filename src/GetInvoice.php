<?php

namespace ecPay\eInvocie;

use Exception;

class GetInvoice extends Content
{
    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '/B2CInvoice/GetIssue';

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
        $dateTime = \DateTime::createFromFormat('Y-m-d', $date);

        if (!($dateTime && $dateTime->format('Y-m-d') == $date)) {
            throw new Exception('The invoice date format is invalid.');
        }

        $this->content['Data']['InvoiceDate'] = $date;

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

        if (empty($this->content['Data']['InvoiceNo'])) {
            throw new Exception('The invoice no is empty.');
        }

        if (empty($this->content['Data']['InvoiceDate'])) {
            throw new Exception('The invoice date is empty.');
        }
    }
}
