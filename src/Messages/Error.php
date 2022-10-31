<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Messages;

use JsonSerializable;
use function get_object_vars;

/**
 * Class Error
 * @package PCore\JsonRpc\Messages
 * @github https://github.com/pcore-framework/json-rpc
 */
class Error implements JsonSerializable
{

    public function __construct(
        protected int    $code,
        protected string $message,
        protected ?array $data = null
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

}
