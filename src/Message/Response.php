<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Message;

use JsonSerializable;

/**
 * Class Response
 * @package PCore\JsonRpc\Message
 * @github https://github.com/pcore-framework/json-rpc
 */
class Response implements JsonSerializable
{

    public function __construct(protected mixed $result)
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
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }

}
