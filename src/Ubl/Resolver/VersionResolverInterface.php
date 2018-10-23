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
     * @param string|\DOMDocument $value
     * @return string
     */
    public function getVersion($value);
}