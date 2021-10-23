<?php
namespace Src\Exceptions\Wallet;

class InvalidWalletClassException extends \Exception
{
    public function __construct($className) {
        $message = 'Wallet class "' . $className . '" has not been defined';

        parent::__construct($message);
    }
}