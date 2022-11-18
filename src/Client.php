<?php

declare(strict_types=1);

namespace PCore\JsonRpc;

use Exception;
use GuzzleHttp\Client as GzClient;
use GuzzleHttp\Exception\GuzzleException;
use PCore\JsonRpc\Messages\{Request, Response};
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @package PCore\JsonRpc
 * @github https://github.com/pcore-framework/json-rpc
 */
class Client
{

    protected GzClient $client;

    public function __construct(
        protected string $uri = '',
    )
    {
        $this->client = new GzClient(['base_uri' => $this->uri]);
    }

    /**
     * @param Request $request
     * @param string $requestMethod
     * @return mixed
     * @throws Exception
     * @throws GuzzleException
     */
    public function call(Request $request, string $requestMethod = 'GET')
    {
        if (!$request->hasId()) {
            $request->setId(md5(uniqid()));
        }
        return Response::createFromPsrResponse($this->sendRequest($request, $requestMethod));
    }

    /**
     * @param Request $request
     * @param string $requestMethod
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendRequest(Request $request, string $requestMethod = 'GET'): ResponseInterface
    {
        return $this->client->request($requestMethod, '/', ['json' => $request]);
    }

    /**
     * @param Request $request
     * @param string $requestMethod
     * @return void
     */
    public function notify(Request $request, string $requestMethod = 'GET'): void
    {
        $this->sendRequest($request, $requestMethod);
    }

}
