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
     * @var VersionResolverInterface
     */
    public $versionResolver;

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
        $name = $document->documentElement->localName;
        if (empty($this->version)) {
            $this->loadVersion($document);
        }
        $path = $this->getFullPath($name);

        return $path;
    }

    private function getFullPath($name)
    {
        $filename = 'UBL-'.$name.'-'.$this->version.self::XSD_EXTENSION;
        $path = $this->baseDirectory.DIRECTORY_SEPARATOR.'maindoc'.DIRECTORY_SEPARATOR.$filename;

        return $path;
    }

    private function loadVersion(\DOMDocument $document)
    {
        if (!$this->versionResolver) {
            $this->versionResolver = new UblVersionResolver();
        }

        $this->version = $this->versionResolver->getVersion($document);
    }
}