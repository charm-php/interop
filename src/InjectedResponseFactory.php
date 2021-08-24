<?php
namespace Charm\Interop;

use Closure;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Traits provides a `responseFactory()` method that returns a
 * `Psr\Http\Message\ResponseFactoryInterface` instance.
 */
trait InjectedResponseFactory {
    public static ?Closure $Psr_Http_Message_ResponseFactoryInterface = null;

    protected function responseFactory(): ResponseFactoryInterface {
        if (self::$Psr_Http_Message_ResponseFactoryInterface !== null) {
            return (self::$Psr_Http_Message_ResponseFactoryInterface)($this);
        }
        if (DefaultFactories::$Psr_Http_Message_ResponseFactoryInterface !== null) {
            return (DefaultFactories::$Psr_Http_Message_ResponseFactoryInterface)($this);
        }
        throw new NotConfiguredException(static::class, '$Psr_Http_Message_ResponseFactoryInterface', ResponseFactoryInterface::class);
    }
}
