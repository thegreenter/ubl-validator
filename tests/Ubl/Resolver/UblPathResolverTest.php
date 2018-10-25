<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 14:09
 */

namespace Tests\Greenter\Ubl\Resolver;

use Greenter\Ubl\Resolver\UblPathResolver;
use Greenter\Ubl\Resolver\VersionResolverInterface;

class UblPathResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UblPathResolver
     */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new UblPathResolver();
        $this->resolver->baseDirectory = '/';
    }

    public function testFoundPathFixedVersion()
    {
        $file = __DIR__.'/../../Resources/2.1/20200464529-01-F001-697.xml';
        $doc = new \DOMDocument();
        $doc->load($file);

        $this->resolver->version = '2.1';

        $path = $this->resolver->getPath($doc);

        $this->assertNotEmpty($path);
        $this->assertStringEndsWith('UBL-Invoice-2.1.xsd', $path);
    }

    public function testFoundPathAutoVersion()
    {
        $file = __DIR__.'/../../Resources/2.1/20200464529-01-F001-697.xml';
        $doc = new \DOMDocument();
        $doc->load($file);

        $path = $this->resolver->getPath($doc);

        $this->assertNotEmpty($path);
        $this->assertStringEndsWith('UBL-Invoice-2.1.xsd', $path);
    }

    public function testVersionEmpty()
    {
        $file = __DIR__.'/../../Resources/2.1/20200464529-01-F001-697.xml';
        $this->resolver->versionResolver = $this->getResolverVersionEmpty();
        $doc = new \DOMDocument();
        $doc->load($file);

        $path = $this->resolver->getPath($doc);

        $this->assertNotEmpty($path);
        $this->assertStringEndsWith('UBL-Invoice-.xsd', $path);
    }

    private function getResolverVersionEmpty()
    {
        $stub = $this->getMockBuilder(VersionResolverInterface::class)->getMock();
        $stub->method('getVersion')
             ->willReturn('');

        /** @var $stub VersionResolverInterface */
        return $stub;
    }
}