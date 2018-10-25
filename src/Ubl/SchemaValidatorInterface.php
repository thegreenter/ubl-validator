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
     * Get last message error or warning.
     *
     * @return string
     */
    public function getMessage();

    /**
     * @param \DOMDocument $document
     * @param string $xsdPath XSD full path
     *
     * @return bool
     */
    public function validate(\DOMDocument $document, $xsdPath);
}