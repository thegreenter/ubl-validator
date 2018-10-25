<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 25/10/2018
 * Time: 15:21
 */

namespace Tests\Greenter\Ubl;

use Greenter\Ubl\SchemaValidator;

class SchemaValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SchemaValidator
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = new SchemaValidator();
    }

    public function testSuccessValidate()
    {
        $xsd = __DIR__.'/../../src/xsd/2.1/maindoc/UBL-Invoice-2.1.xsd';
        $xmlPath = __DIR__.'/../Resources/2.1/20200464529-01-F001-697.xml';
        $doc = new \DOMDocument();
        $doc->load($xmlPath);

        $valid = $this->validator->validate($doc, $xsd);

        $this->assertTrue($valid);
    }

    public function testFailValidate()
    {
        $xsd = __DIR__.'/../../src/xsd/2.1/maindoc/UBL-Invoice-2.1.xsd';
        $doc = new \DOMDocument();
        $doc->loadXML('<root></root>');

        $valid = $this->validator->validate($doc, $xsd);

        $this->assertFalse($valid);
        $this->assertCount(1, $this->validator->getErrors());
    }
}