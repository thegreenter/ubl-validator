<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 10:39
 */

namespace Greenter\Ubl\Resolver;

/**
 * Interface PathResolverInterface
 */
interface PathResolverInterface
{
    /**
     * Get Path XSD.
     *
     * @param \DOMDocument $document
     * @return string|null
     */
    function getPath(\DOMDocument $document);
}