<?php

namespace Cardinity\Exception;

use Cardinity\Method\Error;
use Cardinity\Method\Payment\Payment;
use Cardinity\Method\ResultObject;

class Request extends Runtime
{
    /** @type ResultObject */
    private $result;
    
    /**
     * @param \Exception $previous 
     * @param ResultObject $result instance of Payment or Error object
     * @return slef
     */
    public function __construct(\Exception $previous = null, ResultObject $result = null)
    {
        $this->message .= ' Response data: ' . serialize($result);
        parent::__construct($this->message, $this->code, $previous);

        $this->result = $result;
    }

    /**
     * Get result object of particular response
     * @return Payment|Error
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * List of errors occured
     * @return array
     */
    public function getErrors()
    {
        if ($this->result instanceof Payment) {
            return [
                [
                    'field' => 'status',
                    'message' => $this->result->getError()
                ]
            ];
        }

        return $this->result->getErrors();
    }

    /**
     * Errors in string form
     * @return string
     */
    public function getErrorsAsString()
    {
        $string = '';
        foreach ($this->getErrors() as $error) {
            $string .= sprintf(
                "%s: %s",
                $error['field'],
                $error['message']
            );
            if (isset($error['rejected'])) {
                $string .= sprintf(" ('%s' given)", $error['rejected']);
            }
            $string .= ";\n";
        }

        return trim($string);
    }
}
