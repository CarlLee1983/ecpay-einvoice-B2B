<?php

namespace ecPay\eInvoice;

use ecPay\eInvoice\Parameter\InvoiceTagType;
use ecPay\eInvoice\Parameter\NotifiedType;
use ecPay\eInvoice\Parameter\NotifyType;
use Exception;

class InvoiceNotify extends Content
{
    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '/B2CInvoice/InvoiceNotify';

    /**
     * Initialize invoice content.
     *
     * @return void
     */
    protected function initContent()
    {
        $this->content['Data'] = [
            'MerchantID' => $this->merchantID,
            'InvoiceNo' => '',
            'AllowanceNo' => '',
            'Phone' => '',
            'NotifyMail' => '',
            'Notify' => '',
            'InvoiceTag' => '',
            'Notified' => '',
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
     * Setting invoice allowance no.
     *
     * @param string $number
     * @return InvoiceInterface
     */
    public function setAllowanceNo(string $number): InvoiceInterface
    {
        if (strlen($number) != 16) {
            throw new Exception('The invoice allowance no length should be 16.');
        }

        $this->content['Data']['AllowanceNo'] = $number;

        return $this;
    }

    /**
     * Set notify phone number.
     *
     * @param string $number
     * @return InvoiceInterface
     */
    public function setPhone(string $number): InvoiceInterface
    {
        if (strlen($number) > 20) {
            throw new Exception('Notify phone number should be less than 21 characters');
        }

        $this->content['Data']['Phone'] = $number;

        return $this;
    }

    /**
     * Setting allownace notify email.
     *
     * @param string $email
     * @return InvoiceInterface
     */
    public function setNotifyfMail(string $email): InvoiceInterface
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        if (strlen($email) > 80) {
            throw new Exception('Email length must be less than 80 characters.');
        }

        $this->content['Data']['NotifyMail'] = $email;

        return $this;
    }

    /**
     * Setting the invoice notify type.
     *
     * @param string $type
     * @return InvoiceInterface
     */
    public function setNotify(string $type): InvoiceInterface
    {
        $notifyType = [
            NotifyType::SMS,
            NotifyType::EMAIL,
            NotifyType::ALL,
        ];

        if (!in_array($type, $notifyType)) {
            throw new Exception('Notify type format is invalid.');
        }

        $this->content['Data']['Notify'] = $type;

        return $this;
    }

    /**
     * Setting the invoice notify tag.
     *
     * @param string $tag
     * @return InvoiceInterface
     */
    public function setInvoiceTag(string $tag): InvoiceInterface
    {
        $invoiceTag = [
            InvoiceTagType::INVOICE,
            InvoiceTagType::INVOICE_VOID,
            InvoiceTagType::ALLOWANCE,
            InvoiceTagType::ALLOWANCE_VOID,
            InvoiceTagType::INVOICE_WINNING,
        ];

        if (!in_array($tag, $invoiceTag)) {
            throw new Exception('The invoice notify tag is invalid.');
        }

        $this->content['Data']['InvoiceTag'] = $tag;

        return $this;
    }

    /**
     * Setting Notify targer.
     *
     * @param string $targer
     * @return InvoiceInterface
     */
    public function Notified(string $targer): InvoiceInterface
    {
        $targerList = [
            NotifiedType::CUSTOMER,
            NotifiedType::VENDOR,
            NotifiedType::ALL,
        ];

        if (!in_array($targer, $targerList)) {
            throw new Exception('Notify targer is invalid.');
        }

        $this->content['Data']['Notified'] = $targer;

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
        $data = $this->content['Data'];

        if (empty($data['InvoiceNo'])) {
            throw new Exception('The invoice no is empty.');
        }

        if (
            in_array($data['InvoiceTag'], [
                InvoiceTagType::ALLOWANCE,
                InvoiceTagType::ALLOWANCE_VOID,
            ])) {
            if (empty($data['AllowanceNo'])) {
                throw new Exception('Invoice tag type is allowed or allowed invalid, `AllowanceNo` shulde be set.');
            }
        }

        if (empty($data['Phone']) && empty($data['NotifyMail'])) {
            throw new Exception('Phone number or mail shuld be set.');
        }

        if (empty($data['Notify'])) {
            throw new Exception('Notify is empty.');
        }

        if (empty($data['InvoiceTag'])) {
            throw new Exception('Invoice tag is empty.');
        }

        if (empty($data['Notified'])) {
            throw new Exception('Notified is empty.');
        }
    }
}
