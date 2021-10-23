<?php
namespace Src\Exceptions\Currency;

class InvalidCurrencyClassException extends \Exception
{
    public function __construct($className) {
        $message = 'Currency class "' . $className . '" has not been defined';

        parent::__construct($message);
    }
}