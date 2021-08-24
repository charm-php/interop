<?php
namespace Charm\Interop;

use Closure;

/**
 * These factories will be used if the factory is not configured directly on the 
 * consumer class.
 */
class DefaultFactories {

    /**
     * Set a default factory that returns PSR-3 LoggerInterface instances. The
     * callable will receive the requesting instance as parameter.
     */
    public static ?Closure $Psr_Log_LoggerInterface = null;

    /**
     * Sett a default factory that returns PSR-17 ResponseFactory instances. The
     * callable will receive the requesting instance as parameter.
     *
     * @var Closure|null
     */
    public static ?Closure $Psr_Http_Message_ResponseFactoryInterface = null;

    /**
     * Set a default factory that returns PSR-17 StreamFactory instances. The
     * callable will receive the requesting instance as parameter.
     *
     * @var Closure|null
     */
    public static ?Closure $Psr_Http_Message_StreamFactoryInterface = null;
}
