<?php

namespace ecPay\eInvoice;

use Exception;

class InvalidInvoice extends Content
{
    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '/B2CInvoice/Invalid';

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
            'Reason' => '',
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
     * Setting invoice invalid reason.
     *
     * @param string $reason
     * @return InvoiceInterface
     */
    public function setReason(string $reason): InvoiceInterface
    {
        $this->content['Data']['Reason'] = $reason;

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

        if (empty($this->content['Data']['Reason'])) {
            throw new Exception('The invoice invalid reason is empty.');
        }
    }
}
