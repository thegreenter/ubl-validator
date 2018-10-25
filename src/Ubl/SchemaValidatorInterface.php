<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/01/2018
 * Time: 05:23 PM
 */

namespace Greenter\Ubl;

/**
 * Interface SchemaValidatorInterface
 */
interface SchemaValidatorInterface
{
    /**
     * Get errors list.
     *
     * @return XmlError[]
     */
    public function getErrors();

    /**
     * @param \DOMDocument $document
     * @param string $xsdPath XSD full path
     *
     * @return bool
     */
    public function validate(\DOMDocument $document, $xsdPath);
}