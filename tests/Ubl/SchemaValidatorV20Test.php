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

    public function providerDocs()
    {
        return [
          [__DIR__ . '/../Resources/2.0/20000000001-01-F001-00000003.xml'],
          [__DIR__ . '/../Resources/2.0/20600995805-RA-20170719-01.xml'],
        ];
    }
}