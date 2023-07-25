<?php

namespace ecPay\eInvoice;

use Exception;
use GuzzleHttp\Client;

class Request
{
    use AES;

    /**
     * The request url.
     *
     * @var string
     */
    protected $url = '';

    /**
     * The request body content.
     *
     * @var array
     */
    protected $content = [];

    /**
     * __construct
     *
     * @param string $url
     * @param array $content
     */
    public function __construct(string $url = '', array $content = [])
    {
        $this->url = $url;
        $this->content = $content;
    }

    /**
     * Send request to ecpay server.
     *
     * @param string $url
     * @param array $content
     * @return array
     */
    public function send(string $url = '', array $content = []): array
    {
        try {
            $client = new Client();
            $sendContent = $content ?: $this->content;
            $response = $client->request(
                'POST',
                $url ?: $this->url,
                ['body' => json_encode($sendContent)]
            );

            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            if ($exception->hasResponse()) {
                $response = $e->getResponse();

                throw new Exception($response->getBody()->getContents());
            }

            throw new Exception('Request Error.');
        }
    }
}
