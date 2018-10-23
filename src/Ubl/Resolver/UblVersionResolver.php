<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 23/10/2018
 * Time: 14:52
 */

namespace Greenter\Ubl\Resolver;

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
     * @param string|\DOMDocument $value
     * @return string
     */
    public function getVersion($value)
    {
        $doc = $this->getDocument($value);
        if (!isset($doc)) {
            return '';
        }

        $xpath = $this->getXpath($doc);
        $this->setNs($doc);
        $xpath->registerNamespace('cbc', self::CBC_NS);

        return $this->getSingleValue($xpath, 'cbc:UBLVersionID');
    }

    private function getDocument($value)
    {
        if ($value instanceof \DOMDocument) {
            $doc = $value;
        } else {
            $doc = new \DOMDocument();
            @$doc->loadXML($value);
        }

        if (empty($doc->documentElement)) {
            return null;
        }

        return $doc;
    }

    private function setNs(\DOMDocument $doc)
    {
        $docName = $doc->documentElement->nodeName;

        $this->rootNs = '/'. self::ROOT_PREFIX . ':' . $docName;
    }

    private function getXpath(\DOMDocument $doc)
    {
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace(self::ROOT_PREFIX, $doc->documentElement->namespaceURI);

        return $xpath;
    }

    private function getSingleValue(\DOMXPath $xpath, $query)
    {
        $nodes = $xpath->query($this->rootNs . '/' . $query);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }

        return '';
    }
}