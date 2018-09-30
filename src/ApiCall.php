<?php

namespace Delarge\CoinPayments;

use Delarge\CoinPayments\Agents\RequestAgent;
use Delarge\CoinPayments\Exceptions\JsonException;

class ApiCall
{
    /**
     * Version of API used
     */
    const API_VERSION = 1;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var string
     */
    protected $queryString;

    /**
     * @var RequestAgent
     */
    protected $agent;

    /**
     * @var \Delarge\CoinPayments\Credentials
     */
    protected $credentials;

    public function __construct(string $command, array $parameters, Credentials $credentials)
    {
        $this->command = $command;
        $this->parameters = $parameters;
        $this->credentials = $credentials;
    }

    /**
     * @throws \Delarge\CoinPayments\Exceptions\RequestException
     */
    public function execute()
    {
        $this->getAgent()->setQuerySignature($this->generateQuerySignature());
        $this->getAgent()->setQueryString($this->getQueryString());
        $this->getAgent()->execute();
        $this->response = $this->getAgent()->getResponse();
    }


    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return \Delarge\CoinPayments\Credentials
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * Set-up post request and generate query string
     * @return string
     */
    public function getQueryString(): string
    {
        $request = [
            'version' => self::API_VERSION,
            'cmd' => $this->getCommand(),
            'format' => 'json',
            'key' => $this->getCredentials()->getPublicKey()
        ];

        $request = array_merge($request, $this->getParameters());

        return $this->queryString = http_build_query($request, '', '&');
    }

    /**
     * Calculate the HMAC signature off the POST data
     *
     * @return string
     */
    public function generateQuerySignature()
    {
        return $this->queryString = hash_hmac(
            'sha512',
            $this->getQueryString(),
            $this->getCredentials()->getPrivateKey()
        );
    }

    /**
     * @return \Delarge\CoinPayments\Agents\RequestAgent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param \Delarge\CoinPayments\Agents\RequestAgent $agent
     */
    public function setAgent(RequestAgent $agent): void
    {
        $this->agent = $agent;
    }
}