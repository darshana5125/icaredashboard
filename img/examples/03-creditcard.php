<?php

//require __DIR__ . '/../vendor/autoload.php';
//require __DIR__ . '/../vendor/autoload.php';
require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

use Pachico\Magoo\Magoo;

$magoo = new Magoo();
$magoo->pushCreditCardMask('*');

$mySensitiveString = 'This is my credit card number: 4815 4506 0005 9152 sdfk sfsfk';

echo $magoo->getMasked($mySensitiveString. PHP_EOL);

// This is my credit card number: ······1111.
?>