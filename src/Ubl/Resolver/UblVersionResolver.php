<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 23/10/2018
 * Time: 14:52
 */

namespace Greenter\Ubl\Resolver;

use DOMDocument;
use DOMXPath;

/**
 * Class UblVersionResolver
 */
class UblVersionResolver implements VersionResolverInterface
{
    const ROOT_PREFIX = 'xs';
    const CBC_NS = 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2';

    /**
     * @var string
     */
    private $rootNs;

    /**
     * UBL Version resolver.
     *
     * @param DOMDocument $document
     * @return string
     */
    public function getVersion(DOMDocument $document)
    {
        if (empty($document->documentElement)) {
            return '';
        }

        $xpath = $this->getXpath($document);
        $this->setNs($document);
        $xpath->registerNamespace('cbc', self::CBC_NS);

        return $this->getSingleValue($xpath, 'cbc:UBLVersionID');
    }

    private function setNs(DOMDocument $doc)
    {
        $docName = $doc->documentElement->localName;

        $this->rootNs = '/'. self::ROOT_PREFIX . ':' . $docName;
    }

    private function getXpath(DOMDocument $doc)
    {
        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace(self::ROOT_PREFIX, $doc->documentElement->namespaceURI);

        return $xpath;
    }

    private function getSingleValue(DOMXPath $xpath, $query)
    {
        $nodes = $xpath->query($this->rootNs . '/' . $query);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }

        return '';
    }
}
