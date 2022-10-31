<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Messages;

use InvalidArgumentException;
use JsonSerializable;
use PCore\HttpMessage\Contracts\HeaderInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Request
 * @package PCore\JsonRpc\Messages
 * @github https://github.com/pcore-framework/json-rpc
 */
class Request implements JsonSerializable
{

    public function __construct(
        protected string $method,
        protected string $jsonRpc = '2.0',
        protected array  $params = [],
        protected mixed  $id = null
    )
    {
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    /**
     * @param ServerRequestInterface $request
     * @return static
     */
    public static function createFromPsrRequest(ServerRequestInterface $request): static
    {
        if (!str_contains($request->getHeaderLine(HeaderInterface::HEADER_CONTENT_TYPE), 'application/json')) {
            throw new InvalidArgumentException('Неверный запрос', -32600);
        }
        $body = $request->getBody()->getContents();
        $parts = json_decode($body, true);
        if (!isset($parts['jsonrpc'], $parts['method'])) {
            throw new InvalidArgumentException('Ошибка синтаксического анализа', -32700);
        }
        return new static($parts['method'], $parts['jsonrpc'], $parts['params'] ?? [], $parts['id'] ?? null);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return void
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getJsonRpc(): string
    {
        return $this->jsonRpc;
    }

    /**
     * @param string $jsonRpc
     * @return void
     */
    public function setJsonRpc(string $jsonRpc): void
    {
        $this->jsonRpc = $jsonRpc;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return isset($this->id);
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

}
