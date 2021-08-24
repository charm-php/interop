<?php
namespace Charm\Interop;

class NotConfiguredException extends \Exception {
    public function __construct(string $className, string $propertyToConfigure, string $interfaceToProvide) {
        parent::__construct($className.'::'.$propertyToConfigure.' has not been configured with a factory that provides instances of '.$interfaceToProvide, 500);
    }
}
