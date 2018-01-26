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
     * @var string
     */
    private $version = '2.0';

    /**
     * @param string $version UBL Version '2.0' or '2.1'
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

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
     * @param \DOMDocument|string $value Xml content or DomDocument
     *
     * @return bool
     */
    public function validate($value)
    {
        if ($value instanceof \DOMDocument) {
            $doc = $value;
        } else {
            $doc = new \DOMDocument();
            @$doc->loadXML($value);
        }

        $filename = $this->getFilename($doc->documentElement->nodeName);
        if (!file_exists($filename)) {
            $this->error = 'Schema file not found';

            return false;
        }

        $state = libxml_use_internal_errors(true);
        $result = $doc->schemaValidate($filename);
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

    public function getError($error)
    {
        $msg = $error->code.': '.trim($error->message).' en la linea '.$error->line;

        return $msg;
    }

    private function getFilename($rootName)
    {
        $name = $this->getName($rootName);

        $path = __DIR__.'/../xsd/'.$this->version.'/maindoc/'.$name.'.xsd';

        return $path;
    }

    /**
     * @param $rootName
     * @return string
     */
    private function getName($rootName)
    {
        if ($this->version == '2.0') {
            return $rootName == 'DespatchAdvice' ? 'UBL-DespatchAdvice-2.0' : 'UBLPE-' . $rootName . '-1.0';
        }

        return 'UBL-' . $rootName . '-2.1';
    }
}
