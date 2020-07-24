<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 12:13
 */

namespace Greenter\Ubl\Resolver;

use DOMDocument;

/**
 * Class UblPathResolver
 * @package Greenter\Ubl\Resolver
 */
class UblPathResolver implements PathResolverInterface
{
    const FILE_FORMAT = 'UBL-%s-%s.xsd';

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
     * UblPathResolver constructor.
     */
    public function __construct()
    {
        $this->baseDirectory = __DIR__.'/../../xsd';
    }

    /**
     * Get Path XSD.
     *
     * @param DOMDocument $document
     * @return string|null
     */
    function getPath(DOMDocument $document)
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
        $filename = sprintf(self::FILE_FORMAT, $name, $this->version);
        $path = join(DIRECTORY_SEPARATOR, [$this->baseDirectory, $this->version, 'maindoc', $filename]);

        return $path;
    }

    private function loadVersion(DOMDocument $document)
    {
        if (!$this->versionResolver) $this->versionResolver = new UblVersionResolver();

        $this->version = $this->versionResolver->getVersion($document);
    }
}