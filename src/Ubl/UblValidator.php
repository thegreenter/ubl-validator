<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 12:45
 */

namespace Greenter\Ubl;

use Greenter\Ubl\Resolver\UblPathResolver;
use Greenter\Ubl\Resolver\PathResolverInterface;

/**
 * Class UblValidator
 */
class UblValidator implements UblValidatorInterface
{
    /**
     * @var string
     */
    private $error;
    /**
     * @var PathResolverInterface
     */
    public $pathResolver;
    /**
     * @var SchemaValidatorInterface
     */
    public $schemaValidator;

    /**
     * Get last message error or warning.
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param \DOMDocument|string $value Xml content or DomDocument
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->checkDependencies();
        $doc = $this->getDocument($value);
        if (empty($doc->documentElement)) {
            $this->error = 'Invalid XML Document';
            return false;
        }

        $path = $this->pathResolver->getPath($doc);
        if (empty($path) || !file_exists($path)) {
            $this->error = 'XSD Path not found';
            return false;
        }

        $valid = $this->schemaValidator->validate($doc, $path);
        if (!$valid) {
            $this->error = $this->schemaValidator->getMessage();
        }

        return $valid;
    }

    private function getDocument($value)
    {
        if ($value instanceof \DOMDocument) {
            $doc = $value;
        } else {
            $doc = new \DOMDocument();
            @$doc->loadXML($value);
        }

        return $doc;
    }

    private function checkDependencies()
    {
        if (!$this->pathResolver) $this->pathResolver = new UblPathResolver();
        if (!$this->schemaValidator) $this->schemaValidator = new SchemaValidator();
    }
}