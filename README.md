# UBL Schema Validator

[![Travis-CI](https://img.shields.io/travis/giansalex/ubl-validator.svg?branch=master&style=flat-square)](https://travis-ci.org/giansalex/ubl-validator)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/ubl-validator.svg?label=coverage&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/ubl-validator?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c911fe005e73428591aa13b966bc488a)](https://www.codacy.com/app/giansalex/ubl-validator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/ubl-validator&amp;utm_campaign=Badge_Grade)  
OASIS Universal Business Language Schema Validator - SUNAT.

## Install
Via Composer from [packagist.org](https://packagist.org/packages/greenter/ubl-validator).
```bash
composer require greenter/ubl-validator
```

## Example
```php
use Greenter\Ubl\SchemaValidator;

$validator = new SchemaValidator();
$validator->setVersion('2.0');

$xml = file_get_contents('20000000001-01-F001-1');
$result = $validator->validate($xml);

if ($result) {
  echo 'Validación exitosa';
} else {
  echo $validator->getMessage();
}


```
