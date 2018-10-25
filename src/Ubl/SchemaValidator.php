<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/01/2018
 * Time: 05:26 PM.
 */

namespace Greenter\Ubl;

/**
 * Class SchemaValidator.
 */
class SchemaValidator implements SchemaValidatorInterface
{
    /**
     * @var string
     */
    private $error;

    /**
     * Get last message error or warning.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->error;
    }

    /**
     * @param \DOMDocument $document
     * @param string $xsdPath XSD full path
     *
     * @return bool
     */
    public function validate(\DOMDocument $document, $xsdPath)
    {
        $state = libxml_use_internal_errors(true);
        $result = $document->schemaValidate($xsdPath);
        $this->error = $this->getErrors();
        libxml_use_internal_errors($state);

        return $result;
    }

    private function getErrors()
    {
        $message = '';
        $errors = libxml_get_errors();
        foreach ($errors as $error) {
            $message .= $this->getError($error).PHP_EOL;
        }

        libxml_clear_errors();

        return $message;
    }

    private function getError($error)
    {
        $msg = $error->code.': '.trim($error->message).' en la linea '.$error->line;

        return $msg;
    }
}
