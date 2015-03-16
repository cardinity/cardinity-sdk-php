<?php

namespace Cardinity\Method;

use Cardinity\Exception;

abstract class ResultObject implements ResultObjectInterface
{
    /**
     * Wrap single result error into array of errors
     * @return array
     */
    public function getErrors()
    {
        return [
            [
                'field' => 'status',
                'message' => $this->getError()
            ]
        ];
    }

    /**
     * Return single error
     */
    public function getError()
    {
        return '';
    }

    /**
     * Serializes result object to json object
     * @return string
     */
    public function serialize()
    {
        $data = [];

        $getters = $this->classGetters(get_class($this));
        foreach ($getters as $method) {
            $property = $this->propertyName($method);
            $value = $this->$method();

            if (is_float($value)) {
                $value = sprintf("%01.2f", $value);
            }

            if ($value !== null) {
                $data[$property] = $value;
            }
        }

        return json_encode($data);
    }

    /**
     * Loads result object values from json object
     * @param string $string json
     * @return void
     */
    public function unserialize($string)
    {
        $data = json_decode($string);
        foreach ($data as $property => $value) {
            $method = $this->setterName($property);

            if (is_numeric($value) && strstr($value, '.')) {
                $value = floatval($value);
            }

            $this->$method($value);
        }
    }

    /**
     * @param string $class
     */
    private function classGetters($class)
    {
        return array_filter(get_class_methods($class), function ($value) {
            if ($value == 'getErrors') {
                return false;
            }

            return substr($value, 0, 3) == 'get';
        });
    }

    private function propertyName($method)
    {
        return lcfirst(substr($method, 3));
    }

    private function setterName($property)
    {
        return 'set' . ucfirst($property);
    }
}
