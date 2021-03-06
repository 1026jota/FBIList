<?php
namespace Jota\FbiList\Exceptions;
use Exception;

class ConnectionException extends Exception {

    public $response;

    public function __construct($message, $response)
    {
        $this->response = $response;
        parent::__construct($message);
    }
}
