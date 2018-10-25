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
     * @var XmlError[]
     */
    private $errors;

    /**
     * Get errors list.
     *
     * @return XmlError[]
     */
    public function getErrors()
    {
        return $this->errors;
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
        $this->errors = $this->extractErrors();
        libxml_use_internal_errors($state);

        return $result;
    }

    /**
     * Get errors list.
     *
     * @return XmlError[]
     */
    public function extractErrors()
    {
        $errors = libxml_get_errors();
        $list = [];
        foreach ($errors as $error) {
            $item = new XmlError();
            $item->level = $error->level;
            $item->code = $error->code;
            $item->column = $error->column;
            $item->message = $error->message;
            $item->line = $error->line;
            $list[] = $item;
        }

        libxml_clear_errors();

        return $list;
    }
}
