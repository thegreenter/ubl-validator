<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/01/2018
 * Time: 06:00 PM
 */

namespace Tests\Greenter\Ubl;

use Greenter\Ubl\SchemaValidator;
use Greenter\Ubl\SchemaValidatorInterface;

class SchemaValidatorV20Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SchemaValidatorInterface
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = new SchemaValidator();
        $this->validator->setVersion('2.0');
    }

    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testDocuments($filename)
    {
        $content = file_get_contents($filename);
        $result = $this->validator->validate($content);

        if ($result === false) {
            echo $this->validator->getMessage();
        }

        $this->assertTrue($result);
    }

    public function testNotFoundSchema()
    {
        $result = $this->validator->validate('<root></root>');

        $this->assertFalse($result);
        $this->assertNotEmpty($this->validator->getMessage());
        echo $this->validator->getMessage();
    }

    public function testInvalidSchema()
    {
        $content = file_get_contents(__DIR__.'/../Resources/error.xml');
        $result = $this->validator->validate($content);

        $this->assertFalse($result);
        $this->assertNotEmpty($this->validator->getMessage());
        echo $this->validator->getMessage();
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../Resources/2.0/*.xml');

        return array_map(function ($item) {
            return [$item];
        }, $files);
    }
}