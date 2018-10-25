<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 23/10/2018
 * Time: 14:50
 */

namespace Greenter\Ubl\Resolver;

/**
 * Interface VersionResolverInterface
 */
interface VersionResolverInterface
{
    /**
     * Resolver version from document.
     *
     * @param \DOMDocument $document
     * @return string
     */
    public function getVersion(\DOMDocument $document);
}