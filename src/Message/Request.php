<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Message;

use InvalidArgumentException;
use JsonSerializable;
use PCore\HttpMessage\Contracts\HeaderInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Request
 * @package PCore\JsonRpc\Message
 * @github https://github.com/pcore-framework/json-rpc
 */
class Request implements JsonSerializable
{

    public function __construct(protected string $method)
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
        return new static($parts['method']);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

}
