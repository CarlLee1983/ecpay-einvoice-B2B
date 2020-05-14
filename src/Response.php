<?php

namespace ecPay\eInvoice;

class Response
{
    /**
     * Response data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * __construct
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * Setting data.
     *
     * @param array $data
     * @return Response
     */
    public function setData(array $data): Response
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Response success.
     *
     * @return boolean
     */
    public function success(): bool
    {
        return $this->data['RtnCode'] == 1;
    }

    /**
     * Get response message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->data['RtnMsg'];
    }

    /**
     * Get response data.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
