<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/01/2018
 * Time: 06:24 PM
 */

namespace Tests\Greenter\Ubl;

use Greenter\Ubl\SchemaValidator;
use Greenter\Ubl\SchemaValidatorInterface;

class SchemaValidatorV21Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SchemaValidatorInterface
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = new SchemaValidator();
        $this->validator->setVersion('2.1');
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

    public function providerDocs()
    {
        return [
            [__DIR__ . '/../Resources/2.1/20100454523-07-FC01-211.xml'],
            [__DIR__ . '/../Resources/2.1/20100454523-08-FD01-211.xml'],
            [__DIR__ . '/../Resources/2.1/20200464529-01-F001-697.xml'],
            [__DIR__ . '/../Resources/2.1/20000000001-09-T001-123.xml'],
        ];
    }
}