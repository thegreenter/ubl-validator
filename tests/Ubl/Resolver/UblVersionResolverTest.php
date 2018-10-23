<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 23/10/2018
 * Time: 15:07
 */

namespace Tests\Greenter\Ubl\Resolver;


use Greenter\Ubl\Resolver\UblVersionResolver;

class UblVersionResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UblVersionResolver
     */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new UblVersionResolver();
    }

    public function testSuccessValidate()
    {
        $path = __DIR__.'/../../Resources/2.1/20100454523-07-FC01-211.xml';
        $xml = file_get_contents($path);

        $version = $this->resolver->getVersion($xml);

        $this->assertEquals('2.1', $version);
    }

    public function testSuccessValidateFromDoc()
    {
        $path = __DIR__.'/../../Resources/2.1/20100454523-07-FC01-211.xml';
        $doc = new \DOMDocument();
        $doc->load($path);

        $version = $this->resolver->getVersion($doc);

        $this->assertEquals('2.1', $version);
    }

    public function testNotFoundVersion()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <text>-</text>
</root>
XML;
        $version = $this->resolver->getVersion($xml);

        $this->assertEmpty($version);
    }

    public function testEmptyXML()
    {
        $xml = '';
        $version = $this->resolver->getVersion($xml);

        $this->assertEmpty($version);
    }
}