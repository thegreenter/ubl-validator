<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/01/2018
 * Time: 06:00 PM
 */

namespace Tests\Greenter\Ubl;

use Greenter\Ubl\UblValidator;
use Greenter\Ubl\UblValidatorInterface;

class UblValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UblValidatorInterface
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = new UblValidator();
    }

    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testDocuments($filename)
    {
        echo $filename;
        $content = file_get_contents($filename);
        $result = $this->validator->isValid($content);

        if ($result === false) {
            echo $this->validator->getError();
        }

        $this->assertTrue($result);
    }

    public function testNotFoundSchema()
    {
        $result = $this->validator->isValid('<root></root>');

        $this->assertFalse($result);
        $this->assertNotEmpty($this->validator->getError());
    }

    public function testInvalidSchema()
    {
        $doc = new \DOMDocument();
        $doc->load(__DIR__.'/../Resources/error.xml');
        $result = $this->validator->isValid($doc);

        $this->assertFalse($result);
        $this->assertNotEmpty($this->validator->getError());
    }

    public function providerDocs()
    {
        $files20 = glob(__DIR__.'/../Resources/2.0/*.xml');
        $files21 = glob(__DIR__.'/../Resources/2.1/*.xml');

        $arr1 = array_map(function ($item) {
            return [$item];
        }, $files20);
        $arr2 = array_map(function ($item) {
            return [$item];
        }, $files21);

        return array_merge($arr1, $arr2);
    }
}