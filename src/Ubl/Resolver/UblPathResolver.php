<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 12:13
 */

namespace Greenter\Ubl\Resolver;

/**
 * Class UblPathResolver
 * @package Greenter\Ubl\Resolver
 */
class UblPathResolver implements PathResolverInterface
{
    const XSD_EXTENSION = '.xsd';

    /**
     * UBL Version.
     *
     * @var string
     */
    public $version;

    /**
     * Base XSD Directory
     *
     * @var string
     */
    public $baseDirectory;

    /**
     * Get Path XSD.
     *
     * @param \DOMDocument $document
     * @return string|null
     */
    function getPath(\DOMDocument $document)
    {
        if (empty($document->documentElement)) {
            return null;
        }
        $name = $document->documentElement->localName;
        $path = $this->getFullPath($name);

        if (!file_exists($path)) {
            return null;
        }

        return $path;
    }

    private function getFullPath($name)
    {
        $filename = 'UBL-'.$name.'-'.$this->version.self::XSD_EXTENSION;
        $path = $this->baseDirectory.DIRECTORY_SEPARATOR.'maindoc'.DIRECTORY_SEPARATOR.$filename;

        return $path;
    }
}