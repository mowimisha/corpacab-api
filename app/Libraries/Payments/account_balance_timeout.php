<?php


$data = file_get_contents('php://input');

$handle = fopen('account_balance_timeout.json', 'w');
fwrite($handle, $data);
fclose($handle);
