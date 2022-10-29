<?php

declare(strict_types=1);

namespace PCore\JsonRpc;

use PCore\Aop\Collectors\AbstractCollector;
use PCore\JsonRpc\Attribute\RpcService;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;

/**
 * Class ServiceCollector
 * @package PCore\JsonRpc
 * @github https://github.com/pcore-framework/json-rpc
 */
class ServiceCollector extends AbstractCollector
{

    /**
     * @param string $class
     * @param object $attribute
     * @return void
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public static function collectClass(string $class, object $attribute): void
    {
        if ($attribute instanceof RpcService) {
            $service = $attribute->name;
            make(Server::class)->register($service, $class);
        }
    }

}
