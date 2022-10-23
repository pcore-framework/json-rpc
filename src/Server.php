<?php

declare(strict_types=1);

namespace PCore\JsonRpc;

use ArrayAccess;
use BadMethodCallException;
use PCore\JsonRpc\Message\Request;
use PCore\Utils\Arr;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Class Server
 * @package PCore\JsonRpc
 * @github https://github.com/pcore-framework/json-rpc
 */
class Server
{

    protected array $services = [];

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function http(ServerRequestInterface $request): ResponseInterface
    {
        $rpcRequest = Request::createFromPsrRequest($request);
        if (is_null($service = $this->getService($rpcRequest->getMethod()))) {
            throw new BadMethodCallException('Метод не найден', -32601);
        }
        print_r($service);
    }

    /**
     * @param string $name
     * @return array|ArrayAccess|mixed
     */
    protected function getService(string $name): mixed
    {
        return Arr::get($this->services, $name);
    }

}
