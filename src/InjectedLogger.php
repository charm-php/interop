<?php
namespace Charm\Interop;

use Closure;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * Trait provides a protected method `logger()` which will return an 
 * instance of `Psr\Log\LoggerInterface`. If no logger is configured
 * it returns a logger that writes to STDERR.
 */
trait InjectedLogger {
    
    public static ?Closure $Psr_Log_LoggerInterface = null;

    protected function logger(): LoggerInterface {
        if (self::$Psr_Log_LoggerInterface !== null) {
            return (self::$Psr_Log_LoggerInterface)($this);
        }
        if (DefaultFactories::$Psr_Log_LoggerInterface !== null) {
            return (DefaultFactories::$Psr_Log_LoggerInterface)($this);
        }
        return new class(__CLASS__) implements LoggerInterface {
            use LoggerTrait;

            private $name;

            public function __construct(string $name) {
                $this->name = $name;
            }

            public function log($level, $message, $context = []) {
                $message = self::interpolate($message, $context);
                fwrite(STDERR, date('Y-m-d H:i:s')." [".$this->name."] [$level] $message\n");
            }
        
            private static function interpolate($message, array $context=[]) {
                // build a replacement array with braces around the context keys
                $replace = array();
                foreach ($context as $key => $val) {
                    // check that the value can be cast to string
                    if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                        $replace['{' . $key . '}'] = $val;
                    }
                }
        
                // interpolate replacement values into the message and return
                return strtr($message, $replace);        
            }  
        };
    }
}
