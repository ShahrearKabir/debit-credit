# Debit-Credit
 
Debit-Credit project structure using the [PSR-4](http://www.php-fig.org/psr/psr-4/) standard.

## Summary

Debit-Credit is a base PHP project structure that implements the [PSR-4](http://www.php-fig.org/psr/psr-4/) standard.  The project files are autoloaded using [Composer](https://getcomposer.org/).

## Installation

In order to use the Debit-Credit just clone the git repository to your machine and run composer install.

```
$ git clone https://github.com/ShahrearKabir/debit-credit.git
$ cd debit-credit
$ composer install
$ composer start / start-dev
```

## Test
```
$ vendor/bin/phpunit .\tests\WithdrawTest.php
$ vendor/bin/phpunit .\tests\DepositTest.php
OR
$ composer phpunit
```
## Explore
Open your browser then goto http://localhost:8000/
- Upload your *.csv file. Format Example: "2014-12-31,4,private,withdraw,1200.00,EUR"
- Submit
- Then get desire comission rate

## Explore
- index.php (autoload and Class FileUpload)
- FileUploadView.php; GUI for file upload and view result
- Constant.php contains base configuration value
- Deposit.php contains deposit calculations
- Withdraw.php contains withdraw calculations
- Helper.php contains helper functions
## Usage
Create any classes in the /src folder with the DebitCredit namespace and they will be autoloaded and available for use.

## Issues - how to help?
<!-- If you find any bugs, issues errors or believe we could add further useful functionality let us know via the github [issues page](https://github.com/cringer/psr4-template/issues) for this project here - [https://github.com/cringer/psr4-template/issues](https://github.com/cringer/psr4-template/issues). -->

## Contributors
- Shahrear Kabir : [Github](https://github.com/ShahrearKabir) | [Gmail] shahrear.k@gmail.com