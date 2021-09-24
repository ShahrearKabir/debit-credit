<?php

require __DIR__ . './vendor/autoload.php';

use DebitCredit\View\FileUpload;

$start = microtime(true);
$fileUpload = new FileUpload();
echo "Process took ". number_format(microtime(true) - $start, 10). " seconds.";