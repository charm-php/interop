<?php
namespace Charm\Interop;

use Closure;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Trait creates a method `streamFactory()` that returns an instance of
 * `Psr\Http\Message\StreamFactory`.
 */
trait InjectedStreamFactory {
    public static ?Closure $Psr_Http_Message_StreamFactoryInterface = null;

    public function streamFactory(): StreamFactoryInterface {
        if (self::$Psr_Http_Message_StreamFactoryInterface !== null) {
            return (self::$Psr_Http_Message_StreamFactoryInterface)($this);
        }
        if (DefaultFactories::$Psr_Http_Message_StreamFactoryInterface !== null) {
            return (DefaultFactories::$Psr_Http_Message_StreamFactoryInterface)($this);
        }
        throw new NotConfiguredException(static::class, '$Psr_Http_Message_StreamFactoryInterface', StreamFactoryInterface::class);
    }
}
