<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 12:45
 */

namespace Greenter\Ubl;

use DOMDocument;
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
     * @param DOMDocument|string $value Xml content or DomDocument
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
            $this->error = "XSD Path: :'$path' not found";
            return false;
        }

        $valid = $this->schemaValidator->validate($doc, $path);
        $this->error = $valid ? '' : $this->getErrorMessage($this->schemaValidator->getErrors());

        return $valid;
    }

    private function getDocument($value)
    {
        if ($value instanceof DOMDocument) {
            return $value;
        }

        $doc = new DOMDocument();
        @$doc->loadXML($value);

        return $doc;
    }

    /**
     * @param XmlError[] $errors
     * @return string
     */
    private function getErrorMessage($errors)
    {
        $lines = [];
        foreach ($errors as $error) {
            $lines[] = (string) $error;
        }

        return join(PHP_EOL, $lines);
    }

    private function checkDependencies()
    {
        if (!$this->pathResolver) {
            $this->pathResolver = new UblPathResolver();
            $this->pathResolver->baseDirectory = __DIR__.'/../xsd';
        }
        if (!$this->schemaValidator) $this->schemaValidator = new SchemaValidator();
    }
}