<?php

declare(strict_types=1);

namespace PCore\JsonRpc\Attribute;

use Attribute;

/**
 * Class RpcService
 * @package PCore\JsonRpc\Attribute
 * @github https://github.com/pcore-framework/json-rpc
 */
#[Attribute(Attribute::TARGET_CLASS)]
class RpcService
{

    public function __construct(
        public string $name
    )
    {
    }

}
