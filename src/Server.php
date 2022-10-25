<?php

declare(strict_types=1);

namespace PCore\JsonRpc;

use ArrayAccess;
use BadMethodCallException;
use InvalidArgumentException;
use PCore\Di\Reflection;
use PCore\HttpMessage\Contracts\HeaderInterface;
use PCore\HttpMessage\Response as PsrResponse;
use PCore\JsonRpc\Message\Request;
use PCore\Utils\Arr;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use ReflectionException;
use ReflectionMethod;

/**
 * Class Server
 * @package PCore\JsonRpc
 * @github https://github.com/pcore-framework/json-rpc
 */
class Server
{

    /**
     * @var array
     */
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
        $psrResponse = new PsrResponse();
        $psrResponse = $psrResponse
            ->withHeader(HeaderInterface::HEADER_CONTENT_TYPE, 'application/json; charset=utf-8');
        return $psrResponse;
    }

    /**
     * @param string $name
     * @return array|ArrayAccess|mixed
     */
    protected function getService(string $name): mixed
    {
        return Arr::get($this->services, $name);
    }

    /**
     * @param string $name
     * @param string $class
     * @return void
     * @throws ReflectionException
     */
    public function register(string $name, string $class): void
    {
        if (isset($this->services[$name])) {
            throw new InvalidArgumentException('Сервис \'' . $name . '\' был зарегистрирован');
        }
        foreach (Reflection::methods($class, ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            $reflectionMethodName = $reflectionMethod->getName();
            $this->services[$name][$reflectionMethodName] = [$class, $reflectionMethodName];
        }
    }

}
