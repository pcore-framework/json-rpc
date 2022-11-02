<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Events;

/**
 * Class RpcCalled
 * @package PCore\JsonRpc\Events
 * @github https://github.com/pcore-framework/json-rpc
 */
class RpcCalled
{

    public function __construct(
        protected string $method,
        protected array  $params,
        protected mixed  $id = null,
        protected string $jsonrpc = '2.0'
    )
    {
    }

}
