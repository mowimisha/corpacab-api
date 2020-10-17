<?php

$data = file_get_contents('php://input');

$handle = fopen('account_balance_response.json', 'w');
fwrite($handle, $data);
fclose($handle);
