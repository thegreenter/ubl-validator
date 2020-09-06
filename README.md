# OASIS UBL Schema Validator

[![Github Actions](https://github.com/thegreenter/ubl-validator/workflows/CI/badge.svg)](https://github.com/thegreenter/ubl-validator/actions)
[![Coverage Status](https://img.shields.io/coveralls/thegreenter/ubl-validator.svg?label=coverage&style=flat-square&branch=master)](https://coveralls.io/github/thegreenter/ubl-validator?branch=master)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/b92d9ea802fd430fa2c4895ff2cd04e7)](https://www.codacy.com/gh/thegreenter/ubl-validator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=thegreenter/ubl-validator&amp;utm_campaign=Badge_Grade)
![Mutation Badge](https://badge.stryker-mutator.io/github.com/thegreenter/ubl-validator/master)  
[OASIS](https://www.oasis-open.org/committees/ubl/) Universal Business Language (UBL) Schema Validator.

## Install
Via Composer from [packagist.org](https://packagist.org/packages/greenter/ubl-validator).
```bash
composer require greenter/ubl-validator
```

## Examples
Simple usage.
```php
use Greenter\Ubl\UblValidator;

$xml = file_get_contents('20000000001-01-F001-1.xml');

$validator = new UblValidator();

if ($validator->isValid($xml)) {
  echo 'Success!!!';
} else {
  echo $validator->getError();
}
```

Above example follows next steps:

- Resolve `<cbc:UBLVersionID>`
- Find `XSD` file in [base directory](https://github.com/thegreenter/ubl-validator/tree/master/src/xsd)
- Run `schemaValidate` and gets result

### Change UBL XSD directory

This package not include all UBL xsd, but you can add others xsd directory and use other UBL version. 

```php
use Greenter\Ubl\UblValidator;
use Greenter\Ubl\Resolver\UblPathResolver;

$ubl = new UblValidator();
$ubl->pathResolver = new UblPathResolver();
$ubl->pathResolver->baseDirectory = './my-ubl-xsd';

echo $ubl->isValid('<Invoice ...>');

```
 
`/my-ubl-xsd` directory follows this structure:

```
\my-ubl-xsd
│
├─2.1/
│   ├─ common/
│   └─ maindoc/
│
├─2.2/
│   ├─ common/
│   └─ maindoc/
```

> You can download UBL xsd from [oasis-open](https://docs.oasis-open.org/ubl/)