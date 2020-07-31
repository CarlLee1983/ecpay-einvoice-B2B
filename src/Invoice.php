<?php

namespace ecPay\eInvoice;

use Exception;
use ecPay\eInvoice\Parameter\PrintMark;
use ecPay\eInvoice\Parameter\CarrierType;
use ecPay\eInvoice\Parameter\ClearanceMark;
use ecPay\eInvoice\Parameter\Donation;
use ecPay\eInvoice\Parameter\TaxType;
use ecPay\eInvoice\Parameter\InvType;
use ecPay\eInvoice\Parameter\VatType;

class Invoice extends Content
{
    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '/B2CInvoice/Issue';

    /**
     * The invoice tax type.
     *
     * @var string
     */
    protected $taxType = TaxType::DUTIABLE;

    /**
     * The invoice content.
     *
     * @var array
     */
    protected $content = [];

    /**
     * The invoice items.
     *
     * @var array
     */
    protected $items = [];

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
            'CustomerID' => '',
            'CustomerIdentifier' => '',
            'CustomerName' => '',
            'CustomerAddr' => '',
            'CustomerPhone' => '',
            'CustomerEmail' => '',
            'ClearanceMark' => '',
            'Print' => PrintMark::NO,
            'Donation' => Donation::NO,
            'LoveCode' => '',
            'CarrierType' => CarrierType::NONE,
            'CarrierNum' => '',
            'TaxType' => $this->taxType,
            'SalesAmount' => 0,
            'InvoiceRemark' => '',
            'Items' => [],
            'InvType' => InvType::GENERAL,
            'vat' => VatType::YES,
        ];
    }

    /**
     * Set the invoice customer identifier.
     *
     * @param string $identifier
     * @return InvoiceInterface
     */
    public function setCustomerIdentifier(string $identifier): InvoiceInterface
    {
        $this->content['Data']['CustomerIdentifier'] = $identifier;

        return $this;
    }

    /**
     * Set the invoice customer name.
     *
     * @param string $name
     * @return InvoiceInterface
     */
    public function setCustomerName(string $name): InvoiceInterface
    {
        $this->content['Data']['CustomerName'] = $name;

        return $this;
    }

    /**
     * Set the invoice customer address.
     *
     * @param string $address
     * @return InvoiceInterface
     */
    public function setCustomerAddr(string $address): InvoiceInterface
    {
        $this->content['Data']['CustomerAddr'] = $address;

        return $this;
    }

    /**
     * Set the invoice customer Phone.
     *
     * @param string $phone
     *
     */
    public function setCustomerPhone(string $phone): InvoiceInterface
    {
        $this->content['Data']['CustomerPhone'] = $phone;

        return $this;
    }

    /**
     * Set the invoice customer email.
     *
     * @param string $email
     * @return InvoiceInterface
     */
    public function setCustomerEmail(string $email): InvoiceInterface
    {
        $this->content['Data']['CustomerEmail'] = $email;

        return $this;
    }

    /**
     * Set the invoice clearance mark.
     *
     * @param string $mark
     * @return InvoiceInterface
     */
    public function setClearanceMark(string $mark): InvoiceInterface
    {
        if (!in_array($mark, [ClearanceMark::YES, ClearanceMark::NO])) {
            throw new Exception('Invoice clearance mark format is invalid.');
        }

        $this->content['Data']['ClearanceMark'] = $mark;

        return $this;
    }

    /**
     * Set the invoice print mark.
     *
     * @param string $mark
     * @return InvoiceInterface
     */
    public function setPrintMark(string $mark): InvoiceInterface
    {
        if ($mark != PrintMark::YES && $mark != PrintMark::NO) {
            throw new Exception('Invoice print mark format is wrong.');
        }

        $this->content['Data']['Print'] = (string) $mark;

        return $this;
    }

    /**
     * Set the invoice donation.
     *
     * @param string $donaion
     * @return InvoiceInterface
     */
    public function setDonation(string $donation): InvoiceInterface
    {
        if (!in_array($donation, [Donation::YES,  Donation::NO])) {
            throw new Exception('Invoice donation format is wrong.');
        }

        $this->content['Data']['Donation'] = (string) $donation;

        return $this;
    }

    /**
     * Set the invoice love code.
     *
     * @param string $code
     * @return InvoiceInterface
     */
    public function setLoveCode(string $code): InvoiceInterface
    {
        $counter = strlen($code);

        if ($counter > 7 || $counter < 3) {
            throw new Exception('Invoice love code is wrong.');
        }

        $this->content['Data']['LoveCode'] = (string) $code;

        return $this;
    }

    /**
     * Set the invoice carruer type.
     *
     * @param string $type
     * @return InvoiceInterface
     */
    public function setCarrierType(string $type): self
    {
        $carrierType = [
            CarrierType::NONE,
            CarrierType::MEMBER,
            CarrierType::CITIZEN,
            CarrierType::CELLPHONE,
        ];

        if (!in_array($type, $carrierType)) {
            throw new Exception('Invoice carrier type format is wrong.');
        }

        $this->content['Data']['CarrierType'] = (string) $type;

        return $this;
    }

    /**
     * Set the invoice carruer number.
     *
     * @param string $number
     * @return InvoiceInterface
     */
    public function setCarrierNum(string $number): InvoiceInterface
    {
        $this->content['Data']['CarrierNum'] = $number;

        return $this;
    }

    /**
     * Set the invoice tax type.
     *
     * @param string $type
     * @return InvoiceInterface
     */
    public function setTaxType(string $type): InvoiceInterface
    {
        $taxType = [
            TaxType::DUTIABLE,
            TaxType::ZERO,
            TaxType::FREE,
            TaxType::MIX,
        ];

        if (!in_array($type, $taxType)) {
            throw new Excpetion('Invoice tax type format is invalid.');
        }

        $this->taxType = $type;
        $this->content['Data']['TaxType'] = $type;

        return $this;
    }

    /**
     * Set the invoice special tax type.
     *
     * @param string $type
     * @return InvoiceInterface
     */
    public function setSpecialTaxType(string $type): InvoiceInterface
    {
        $this->content['Data']['SpecialTaxType'] = $type;

        return $this;
    }

    /**
     * Set the invoice sales amount.
     *
     * @param int $amount
     *
     */
    public function setSalesAmount(int $amount): InvoiceInterface
    {
        if ($amount <= 0) {
            throw new Excpetion('Invoice sales amount is invalid.');
        }

        $this->content['Data']['SalesAmount'] = $amount;

        return $this;
    }

    /**
     * Set the invoice item.
     *
     * @param array $items
     * @return InvoiceInterface
     */
    public function setItems(array $items): InvoiceInterface
    {
        $this->content['Data']['SalesAmount'] = 0;
        $this->items = [];
        $fields = ['name', 'quantity', 'unit', 'price'];

        foreach ($items as $item) {
            foreach ($fields as $name) {
                if (!isset($item[$name])) {
                    throw new Exception('Items field' . $name . ' not exists.');
                }
            }

            $this->items[] = [
                'ItemName' => $item['name'],
                'ItemCount' => (int) $item['quantity'],
                'ItemWord' => $item['unit'],
                'ItemPrice' => (int) $item['price'],
                'ItemTaxType' => $this->taxType,
                'ItemAmount' => $item['quantity'] * $item['price'],
            ];

            $this->content['Data']['SalesAmount'] += $item['quantity'] * $item['price'];
        }

        return $this;
    }

    /**
     * Get the invoice content.
     *
     * @return array
     */
    public function getContent(): array
    {
        $this->content['Data']['Items'] = $this->items;

        return parent::getContent();
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

        if (empty($data['RelateNumber'])) {
            throw new Exception('The invoice RelateNumber is empty.');
        }

        if ($data['Print'] == PrintMark::YES) {
            if (empty($data['CustomerName']) || empty($data['CustomerAddr'])) {
                throw new Exception('Because print mark is yes. Customer name and address can not be empty.');
            }
        }

        if (empty($data['CustomerPhone']) && empty($data['CustomerEmail'])) {
            throw new Exception('You should be settings either of customer phone and email.');
        }

        if ($data['TaxType'] == TaxType::ZERO) {
            if (empty($data['ClearanceMark'])) {
                throw new Exception('Invoice is duty free, clearance mark can not be empty.');
            }
        }

        if (!empty($data['CustomerIdentifier']) || !empty($data['CustomerName'])) {
            if (empty($data['CustomerIdentifier'])) {
                throw new Exception('Because setting CustomerIdentifier, must setting CustomerName');
            }

            if (empty($data['CustomerName'])) {
                throw new Exception('Because setting CustomerName, must setting CustomerIdentifier');
            }

            if ($data['Print'] == PrintMark::NO) {
                throw new Exception('Because custmoer identifier not empy, print mark must be Yes');
            }

            if ($data['Donation'] == Donation::YES) {
                throw new Exception('Customer identifier not empty, donation can not be yes.');
            }
        }

        if ($data['Donation'] == Donation::YES) {
            if (empty($data['LoveCode'])) {
                throw new Exception('Donation is yes, love code required.');
            }

            if ($data['Print'] == PrintMark::YES) {
                throw new Exception('Donation is yes, invoice can not be print.');
            }
        }

        if ($data['CarrierType'] == CarrierType::NONE && $data['CarrierNum'] != '') {
            throw new Exception('Invoice carruer type is empty, carruer number must be empty.');
        } else {
            if ($data['Print'] == PrintMark::YES && $data['CarrierType'] != CarrierType::NONE) {
                throw new Exception('carruer type no empty, invoice can not be print.');
            }

            if ($data['CarrierType'] == CarrierType::MEMBER && $data['CarrierNum'] != '') {
                throw new Exception('Invoice carruer type is member, carruer number must be empty.');
            }

            if ($data['CarrierType'] == CarrierType::CITIZEN && strlen($data['CarrierNum']) != 16) {
                throw new Exception('Invoice carruer type is citizen, carruer number length must be 16.');
            }

            if ($data['CarrierType'] == CarrierType::CELLPHONE && strlen($data['CarrierNum']) != 8) {
                throw new Exception('Invoice carruer type is Cellphone, carruer number length must be 8.');
            }
        }

        $this->validatorItems();
    }

    /**
     * The invoice items validation.
     *
     * @return void
     */
    protected function validatorItems()
    {
        if (empty($this->content['Data']['Items'])) {
            throw new Exception('Invoice data items is Empty.');
        }

        $amount = 0;

        foreach ($this->items as $item) {
            $amount += $item['ItemAmount'];
        }

        if ($this->content['Data']['SalesAmount'] != $amount) {
            throw new Exception('Invoice sales amount not equal items amount');
        }
    }
}
