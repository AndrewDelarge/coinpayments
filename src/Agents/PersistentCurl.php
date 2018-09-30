<?php

namespace Delarge\CoinPayments\Agents;

use Delarge\CoinPayments\Exceptions\RequestException;

class PersistentCurl extends RequestAgent
{
    /**
     * @var int
     */
    protected $requestCounter = 0;

    /**
     * Max number of request
     * @var int
     */
    protected $requestLimit = 3;

    /**
     * Request throttling in seconds
     * @var int
     */
    protected $throttleTimeout = 1;

    /**
     * @return mixed
     * @throws \Delarge\CoinPayments\Exceptions\RequestException
     */
    public function query()
    {
        $curlHandler = curl_init(self::API_URL);
        curl_setopt($curlHandler, CURLOPT_FAILONERROR, true);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array('HMAC: '. $this->getQuerySignature()));
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $this->getQueryString());

        while (! $this->rawResponse && $this->requestCounter <= $this->requestLimit) {
            if ($this->requestCounter > 0) {
                \sleep($this->throttleTimeout);
            }
            $this->requestCounter++;
            $this->rawResponse = curl_exec($curlHandler);
        }


        if ($this->rawResponse === false) {
            throw new RequestException('cURL error: '.curl_error($curlHandler));
        }
        curl_close($curlHandler);

        return $this->rawResponse;
    }
}