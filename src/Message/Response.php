<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Message;

use Exception;
use JsonSerializable;
use PCore\HttpMessage\Contracts\HeaderInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Response
 * @package PCore\JsonRpc\Message
 * @github https://github.com/pcore-framework/json-rpc
 */
class Response implements JsonSerializable
{

    public function __construct(
        protected mixed  $result,
        protected mixed  $id,
        protected ?Error $error = null,
        protected string $jsonRpc = '2.0',
    )
    {
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return array_filter(get_object_vars($this));
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws Exception
     */
    public static function createFromPsrResponse(ResponseInterface $response): mixed
    {
        if (!str_contains($response->getHeaderLine(HeaderInterface::HEADER_CONTENT_TYPE), 'application/json')) {
            throw new Exception('Неверный запрос', -32600);
        }
        $body = $response->getBody()->getContents();
        return json_decode($body, true);
    }

    /**
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getJsonRpc(): string
    {
        return $this->jsonRpc;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return Error|null
     */
    public function getError(): ?Error
    {
        return $this->error;
    }

}
