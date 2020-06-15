<?php

namespace ecPay\eInvoice;

use Exception;

abstract class Content implements InvoiceInterface
{
    use AES;

    /**
     * ECPay invoice api version.
     */
    const VERSION = '3.0.0';

    /**
     * The request server.
     *
     * @var string
     */
    protected $requestServer = '';

    /**
     * The request path.
     *
     * @var string
     */
    protected $requestPath = '';

    /**
     * The content merchant id.
     *
     * @var string
     */
    protected $merchantID = '';

    /**
     * Hash key;
     *
     * @var string
     */
    protected $hashKey = '';

    /**
     * Hash IV.
     *
     * @var string
     */
    protected $hashIV = '';

    /**
     * The Response instance.
     *
     * @var Response
     */
    public $response;

    /**
     * __construct
     *
     * @param string $server
     * @param string $merchantId
     * @param string $hashKey
     * @param string $hashIV
     */
    public function __construct(string $server, string $merchantId = '', string $hashKey = '', string $hashIV = '')
    {
        $this->response = new Response();
        $this->requestServer = $server;

        $this->setMerchantID($merchantId);
        $this->setHashKey($hashKey);
        $this->setHashIV($hashIV);

        $this->content = [
            'MerchantID' => $this->merchantID,
            'RqHeader' => [
                'Timestamp' => time(),
                'RqID' => $this->getRqID(),
                'Revison' => self::VERSION,
            ]
        ];

        $this->initContent();
    }

    /**
     * Initialize invoice content.
     *
     * @return void
     */
    protected function initContent()
    {
        $this->content = [];
    }

    /**
     * Set the content merchant id.
     *
     * @param string $id
     * @return Content
     */
    public function setMerchantID(string $id): Content
    {
        $this->merchantID = $id;

        return $this;
    }

    /**
     * Set hash key.
     *
     * @param string $key
     * @return $this
     */
    public function setHashKey($key)
    {
        $this->hashKey = $key;

        return $this;
    }

    /**
     * Set hash iv.
     *
     * @param string $iv
     * @return $this
     */
    public function setHashIV($iv)
    {
        $this->hashIV = $iv;

        return $this;
    }

    /**
     * Get the RqID.
     *
     * @return string
     */
    protected function getRqID(): string
    {
        list($usec, $sec) = explode(' ', microtime());
        $usec = str_replace('.', '', $usec);

        return $sec . $this->randomString(5) . $usec . $this->randomString(5);
    }

    /**
     * Get random string.
     *
     * @param integer $length
     * @return string
     */
    private function randomString($length = 32): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if (!is_int($length) || $length < 0) {
            return '';
        }

        $charactersLength = strlen($characters) - 1;
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $charactersLength)];
        }

        return $string;
    }

    /**
     * Trans php urlencode to .net encode.
     *
     * @param string $macValue
     * @return string
     */
    protected function transUrlencode($param)
    {
        $list = [
            '%2d' => '-',
            '%5f' => '_',
            '%2e' => '.',
            '%21' => '!',
            '%2a' => '*',
            '%28' => '(',
            '%29' => ')',
        ];

        foreach ($list as $key => $value) {
            $param = str_replace($key, $value, $param);
        }

        return $param;
    }

    /**
     * Setting Relate number.
     *
     * @param string $relateNumber
     * @return InvoiceInterface
     */
    public function setRelateNumber(string $relateNumber): InvoiceInterface
    {
        if (strlen($relateNumber) > 30) {
            throw new Exception('The invoice RelateNumber length over 30.');
        }

        $this->content['Data']['RelateNumber'] = $relateNumber;

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

        if (!($dateTime && $dateTime->format($format) === $date)) {
            throw new Exception('The invoice date format is invalid.');
        }

        $this->content['Data']['InvoiceDate'] = $date;

        return $this;
    }

    /**
     * Get content.
     *
     * @return array
     */
    public function getContent(): array
    {
        $this->validation();

        $content = $this->content;
        $content['Data'] = json_encode($content['Data']);
        $content['Data'] = urlencode($content['Data']);
        $content['Data'] = $this->transUrlencode($content['Data']);
        $content['Data'] = $this->encrypt($content['Data']);

        return $content;
    }

    /**
     * Validator base parameters.
     *
     * @return void
     */
    protected function validatorBaseParam()
    {
        if (empty($this->content['MerchantID']) || empty($this->content['Data']['MerchantID'])) {
            throw new Exception('MerchantID is empty.');
        }

        if (empty($this->hashKey)) {
            throw new Exception('HashKey is empty.');
        }

        if (empty($this->hashIV)) {
            throw new Exception('HashIV is empty.');
        }
    }

    /**
     * Send request.
     *
     * @param string $url
     * @return array
     */
    public function sendRequest()
    {
        $body = (new Request($this->requestServer . $this->requestPath, $this->getContent()))->send();
        $body['Data'] = $this->decrypt($body['Data']);
        $body['Data'] = json_decode($body['Data'], true);
        $this->response->setData($body['Data']);

        return $body;
    }

    /**
     * Get response.
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
